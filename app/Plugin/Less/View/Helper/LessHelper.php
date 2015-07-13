<?php
/**
 * LESS to CSS Converter Plugin
 *
 * This plugin compiles your .less files to regular CSS withouth relying on
 * client- or serverside JavaScript
 *
 * Relies on the lessify.inc.php class in Vendor/lessphp
 *
 * PHP versions 4 and 5
 *
 * Mindthecode: http://www.mindthecode.com
 * Copyright 2011, Stef van den Ham
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Stef van den Ham
 * @copyright     Copyright 2011, Mindthecode (http://www.mindthecode.com)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('Component', 'Controller');
App::import('Vendor', 'leafo',
    array(
        'file' => 'leafo' . DS . 'lessphp' . DS . 'lessify.inc.php'
    )
);

class LessHelper extends AppHelper
{

    public $helpers = array('Minify');

    public function __construct(View $View, $options = array())
    {
        parent::__construct($View, $options);
        $this->lessFolder = new Folder(WWW_ROOT . 'less');
        $this->cssFolder = new Folder(WWW_ROOT . 'css');
    }

    public function css($file, $options = array())
    {

        if (isset($options['theme']) and trim($options['theme'])) {
            $this->set_theme($options['theme']);
        } else {
            $this->lessFolder = new Folder(WWW_ROOT . 'less');
            $this->cssFolder = new Folder(WWW_ROOT . 'css');
        }
        if (isset($options['plugin']) and trim($options['plugin'])) {
            $this->set_plugin($options['plugin']);
        } else {
            $this->lessFolder = new Folder(WWW_ROOT . 'less');
            $this->cssFolder = new Folder(WWW_ROOT . 'css');
        }

        if (is_array($file)) {
            foreach ($file as $candidate) {
                $source = $this->lessFolder->path . DS . $candidate . '.less';
                $target = str_replace('.less', '.css', str_replace($this->lessFolder->path, $this->cssFolder->path, $source));
                $this->auto_compile_less($source, $target);
            }
        } else {
            $source = $this->lessFolder->path . DS . $file . '.less';
            $target = str_replace('.less', '.css', str_replace($this->lessFolder->path, $this->cssFolder->path, $source));
            $this->auto_compile_less($source, $target);

        }
        if (isset($options['plugin']) and trim($options['plugin'])) {
            $file = $options['plugin'] . '.' . $file;
        }

        return $file;
    }

    /**
     * When called, will reset lessFolder for specific theme
     *
     * @note Note that it assumes themes are stored in app/View/Themed
     *
     * @param string $theme_name
     */
    private function set_theme($theme_name)
    {

        $app_root = ROOT . DS . APP_DIR;

        $theme_path = DS . $app_root . DS . 'View' . DS . 'Themed' . DS . $theme_name . DS . 'webroot' . DS;
        $this->lessFolder = new Folder($theme_path . 'less');
        $this->cssFolder = new Folder($theme_path . 'css');

    }

    private function set_plugin($plugin_name)
    {
        $app_root = ROOT . DS . APP_DIR;
        $plugin_path = $app_root . DS . 'Plugin' . DS . $plugin_name . DS . 'webroot' . DS;
        $this->lessFolder = new Folder($plugin_path . 'less');
        $this->cssFolder = new Folder($plugin_path . 'css');
    }

    public function auto_compile_less($lessFilename, $cssFilename, $plugin = null)
    {

        // Check if cache & output folders are writable and the less file exists.
        if (!is_writable(CACHE . 'less')) {
            trigger_error(__d('cake_dev', '"%s" directory is NOT writable.', CACHE . 'less'), E_USER_NOTICE);

            return;
        }

        if (file_exists($lessFilename) == false) {
            trigger_error(__d('cake_dev', 'File: "%s" not found.', $lessFilename), E_USER_NOTICE);

            return;
        }

        // Cache location
        $cacheFilename = CACHE . 'less' . DS . str_replace('/', '_', str_replace($this->lessFolder->path, '', $lessFilename) . ".cache");

//         Load the cache
        if (file_exists($cacheFilename)) {
            $cache = unserialize(file_get_contents($cacheFilename));
        } else {
            $cache = $lessFilename;
        }

        $new_cache = Lessify::cexecute($cache);
        if (!is_array($cache) || $new_cache['updated'] > $cache['updated'] || file_exists($cssFilename) === false || md5(serialize($new_cache)) != md5(serialize($cache))) {
            $cssFile = new File($cssFilename, true);
            /*debug('Less cache rebuilt');*/
            if ($cssFile->write($new_cache['compiled']) === false) {
                if (!is_writable(dirname($cssFilename))) {
                    trigger_error(__d('cake_dev', '"%s" directory is NOT writable.', dirname($cssFilename)), E_USER_NOTICE);
                }
                trigger_error(__d('cake_dev', 'Failed to write "%s"', $cssFilename), E_USER_NOTICE);
            }

            $cacheFile = new File($cacheFilename, true);
            $cacheFile->write(serialize($new_cache));
        }
    }

}
