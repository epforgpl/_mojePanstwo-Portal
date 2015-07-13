<?php
/* /app/View/Helper/LinkHelper.php */
App::uses('AppHelper', 'View/Helper');

class CombinatorHelper extends AppHelper
{
    var $helpers = array('Html');

    var $Vue = null;
    var $libs = array('js' => array(), 'css' => array());
    var $viewLibs = array('js' => array(), 'css' => array());
    var $inline_code = array('js' => array(), 'css' => array());
    var $basePath = null;
    var $cachePath = null;
    var $extraPath = null;

    // default conf
    private $__options = array(
        'js' => array(
            'path' => '/js',
            'cachePath' => '/cache-js',
            'enableCompression' => true
        ),
        'css' => array(
            'path' => '/css',
            'cachePath' => '/cache-css',
            'enableCompression' => true
        )
    );

    function __construct(View $View, $options = array())
    {
        parent::__construct($View, $options);
        $this->__options['js'] = !empty($options['js']) ? am($this->__options['js'], $options['js']) : $this->__options['js'];

        $this->__options['js'] = !empty($options['js']) ? am($this->__options['js'], $options['js']) : $this->__options['js'];
        $this->__options['css'] = !empty($options['css']) ? am($this->__options['css'], $options['css']) : $this->__options['css'];
        $this->Vue = ClassRegistry::getObject('view');

        $this->__options['js']['path'] = $this->clean_path($this->__options['js']['path']);
        $this->__options['js']['cachePath'] = $this->clean_path($this->__options['js']['cachePath']);
        $this->__options['css']['path'] = $this->clean_path($this->__options['css']['path']);
        $this->__options['css']['cachePath'] = $this->clean_path($this->__options['css']['cachePath']);

        $this->basePath['js'] = WWW_ROOT . $this->__options['js']['path'];
        $this->cachePath['js'] = WWW_ROOT . $this->__options['js']['cachePath'];
        $this->basePath['css'] = WWW_ROOT . $this->__options['css']['path'];
        $this->cachePath['css'] = WWW_ROOT . $this->__options['css']['cachePath'];

        if (Configure::read('App.baseUrl')) {
            $this->extraPath = 'app/webroot/'; // URL Rewrites are switched off, so wee need to add this extra path.
        } else {
            $this->extraPath = ''; // .htaccess files will take care of everything
        }
    }

    private function clean_path($path)
    {
        // delete the / at the end of the path
        $len = strlen($path);
        if (strrpos($path, '/') == ($len - 1)) {
            $path = substr($path, 0, $len - 1);
        }

        // delete the / at the start of the path
        if (strpos($path, '/') == '0') {
            $path = substr($path, 1, $len);
        }

        return $path;
    }

    function scripts($type, $async = false)
    {
        switch ($type) {
            case 'js':
                $this->libs[$type] = array_merge($this->libs[$type], $this->viewLibs[$type]);

                if (Configure::read('debug') > 0) {
                    return $this->Html->script($this->libs[$type]);

                } else {
                    $cachefile_js = $this->generate_filename('js');

                    return $this->get_js_html($cachefile_js, $async);
                }
            case 'css':
                $this->libs[$type] = array_merge($this->libs[$type], $this->viewLibs[$type]);

                if (Configure::read('debug') > 0) {
                    return $this->Html->css($this->libs[$type]);

                } else {
                    $cachefile_css = $this->generate_filename('css');

                    return $this->get_css_html($cachefile_css);
                }
            default:
                $this->libs['js'] = array_merge($this->libs['js'], $this->viewLibs['js']);
                $cachefile_js = $this->generate_filename('js');
                $output_js = $this->get_js_html($cachefile_js, $async);
                $this->libs[$type] = array_merge($this->libs[$type], $this->viewLibs[$type]);
                $cachefile_css = $this->generate_filename('css');
                $output_css = $this->get_css_html($cachefile_css);

                return $output_css . "\n" . $cachefile_js;
        }
    }

    private function generate_filename($type)
    {
        $this->libs[$type] = array_unique($this->libs[$type]);

        // Create cache folder if not exist
        if (!file_exists($this->cachePath[$type])) {
            mkdir($this->cachePath[$type]);
        }

        // Define last modified to refresh cache if needed
        $lastmodified = 0;
        foreach ($this->libs[$type] as $key => $lib) {
            $lib = $this->clean_lib_list($lib, $type);

            $tfile = str_replace('.' . $type, '', $lib);
            $partials = preg_split('/\./', $tfile, -1, PREG_SPLIT_NO_EMPTY);

            if (count($partials) > 1) {
                $path = APP . 'Plugin' . DS . array_shift($partials) . DS . 'webroot' . DS . $type . DS . implode('.', $partials) . '.' . $type;
                if (file_exists($path)) {
                    $lastmodified = max($lastmodified, filemtime($path));
                }
            } else if (file_exists($this->basePath[$type] . '/' . $lib)) {
                $lastmodified = max($lastmodified, filemtime($this->basePath[$type] . '/' . $lib));
            }
            $this->libs[$type][$key] = $lib;
        }
        $hash = implode('-', $this->libs[$type]);
        $hash = $lastmodified . '-' . md5(Inflector::slug(str_replace('css', '', strtolower($hash)), '-')) . '-' . md5(serialize($this->inline_code[$type]));

        return 'cache-' . $hash . '.' . $type;
    }

    private function clean_lib_list($filename, $type)
    {
        if (strpos($filename, '?') === false) {
            if (strpos($filename, '.' . $type) === false) {
                $filename .= '.' . $type;
            }
        }

        return $filename;
    }

    private function get_js_html($cachefile, $async)
    {
        if (false === file_exists($this->cachePath['js'] . '/' . $cachefile)) {
            // Get the content
            $file_content = '';
            foreach ($this->libs['js'] as $lib) {
                if (preg_match('/http\:\/\//', $lib) || strpos($lib, '//') === 0) {
                    if (strpos($lib, '//') === 0) {
                        $lib = 'http:' . $lib;
                    }
                    $file_content .= "\n\n" . file_get_contents($lib);
                } else {
                    $tfile = str_replace('.js', '', $lib);
                    $partials = preg_split('/\./', $tfile, -1, PREG_SPLIT_NO_EMPTY);
                    if (count($partials) > 1) {
                        $path = APP . 'Plugin' . DS . array_shift($partials) . DS . 'webroot' . DS . 'js' . DS . implode('.', $partials) . '.js';
                        if (file_exists($path)) {
                            $file_content .= "\n\n" . file_get_contents($path);
                        }
                    } else {
                        $file_content .= "\n\n" . file_get_contents($this->basePath['js'] . '/' . $lib);
                    }
                }
            }

            // If compression is enable, compress it !
            if ($this->__options['js']['enableCompression']) {
                App::import('Vendor', 'Combinator.jsmin/jsmin');
                $file_content = trim(JSMin::minify($file_content));
            }

            // Get inline code if exist
            // Do it after jsmin to preserve variable's names
            if (!empty($this->inline_code['js'])) {
                foreach ($this->inline_code['js'] as $inlineJs) {
                    $file_content .= "\n\n" . $inlineJs;
                }
            }

            if ($fp = fopen($this->cachePath['js'] . '/' . $cachefile, 'wb')) {
                fwrite($fp, $file_content);
                fclose($fp);
            }
        }

        return '<script ' . ($async == true ? 'async ' : '') . 'src="' . $this->url('/' . $this->extraPath . $this->__options['js']['cachePath'] . '/' . $cachefile) . '" type="text/javascript"></script>';
    }

    private function get_css_html($cachefile)
    {
        if (false === file_exists($this->cachePath['css'] . '/' . $cachefile)) {
            // Get the content
            $file_content = '';
            foreach ($this->libs['css'] as $lib) {
                if (preg_match('/http\:\/\//', $lib) || strpos($lib, '//') === 0) {
                    if (strpos($lib, '//') === 0) {
                        $lib = 'http:' . $lib;
                    }
                    $file_content .= "\n\n" . file_get_contents($lib);
                } else {
                    $tfile = str_replace('.css', '', $lib);
                    $partials = preg_split('/\./', $tfile, -1, PREG_SPLIT_NO_EMPTY);
                    if (count($partials) > 1) {
                        $path = APP . 'Plugin' . DS . array_shift($partials) . DS . 'webroot' . DS . 'css' . DS . implode('.', $partials) . '.css';
                        if (file_exists($path)) {
                            $file_content .= "\n\n" . file_get_contents($path);
                        }
                    } else {
                        $file_content .= "\n\n" . file_get_contents($this->basePath['css'] . '/' . $lib);
                    }

                }
            }
            // Get inline code if exist
            if (!empty($this->inline_code['css'])) {
                foreach ($this->inline_code['css'] as $inlineCss) {
                    $file_content .= "\n\n" . $inlineCss;
                }
            }

            // If compression is enable, compress it !
            if ($this->__options['css']['enableCompression']) {
                App::import('Vendor', 'Combinator.cssmin', array('file' => 'cssmin' . DS . 'cssmin.php'));
                $css_minifier = new CssMinifier($file_content); // JossToDo - here we could implement filters and plugins, as per http://code.google.com/p/cssmin/wiki/Configuration
                $file_content = $css_minifier->getMinified();
            }

            if ($fp = fopen($this->cachePath['css'] . '/' . $cachefile, 'wb')) {
                fwrite($fp, $file_content);
                fclose($fp);
            }
        }

        return '<link href="' . $this->url('/' . $this->extraPath . $this->__options['css']['cachePath'] . '/' . $cachefile) . '" rel="stylesheet" type="text/css" >';
    }

    function add_libs($type, $libs, $toEnd = true)
    {
        switch ($type) {
            case 'js':
            case 'css':
                if (is_array($libs)) {
                    foreach ($libs as $lib) {
                        if ($toEnd) {
                            $this->viewLibs[$type][] = $lib;
                        } else {
                            $this->libs[$type][] = $lib;
                        }
                    }
                } else {
                    if ($toEnd) {
                        $this->viewLibs[$type][] = $libs;
                    } else {
                        $this->libs[$type][] = $libs;
                    }
                }
                break;
        }
    }

    function reset_lib_list($type)
    {
        switch ($type) {
            case 'js':
            case 'css':
                $this->libs[$type] = array();
                break;
        }
    }

    function add_inline_code($type, $codes)
    {
        switch ($type) {
            case 'js':
            case 'css':
                if (is_array($codes)) {
                    foreach ($codes as $code) {
                        $this->inline_code[$type][] = $code;
                    }
                } else {
                    $this->inline_code[$type][] = $codes;
                }
                break;
        }
    }
}