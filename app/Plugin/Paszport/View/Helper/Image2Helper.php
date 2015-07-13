<?php

/**
 *
 * Modification of orignal Image helper boundled with Croogo
 *
 *
 * @version 1.42
 * @author Josh Hundley
 * @author Jorge Orpinel <jop@levogiro.net> (changes)
 * @author Juraj Jancuska <jjancuska@gmail.com> (minor changes)
 */
class Image2Helper extends AppHelper
{

    /**
     * Used helpers
     *
     * @var array
     */
    public $helpers = array(
        'Html'
    );
    /**
     * Original image sizes
     *
     * @var array
     */
    public $sizes = false;
    /**
     * Server path
     *
     * @var string
     */
    public $serverPath = false;
    /**
     * Cache dir for "resize" method, relative to 'img'.DS
     * retained for backward compatibility
     *
     * @var array
     */
    public $cacheDir = 'resized';
    public $sourceDir = '';
    /**
     * Cache filename
     *
     * @var string
     */
    protected $_cacheServerPath = false;

    /**
     * Resize image
     *
     * @param integer $width
     * @param integer $height
     * @param boolean $ratio
     *
     * @return object
     */
    public function resizeit($width, $height, $ratio = true)
    {

        if ($this->_cacheServerPath) {
            $this->source($this->_cacheServerPath, true);
        }
        if ($ratio) {
            if (($this->sizes[1] / $height) > ($this->sizes[0] / $width)) {
                $width = ceil(($this->sizes[0] / $this->sizes[1]) * $height);
            } else {
                $height = ceil($width / ($this->sizes[0] / $this->sizes[1]));
            }
        }
        $this->_nativeResize(0, 0, $width, $height, 'resize');

        return $this;
    }

    /**
     * Load image
     *
     * @param string $path Path to image relative to webroot
     * @param boolean $absolute Path is absolute server path
     *
     * @return object $this
     */
    public function source($path = '', $absolute = false)
    {

        $this->sizes = false;
        $this->serverPath = false;
        $this->_cacheServerPath = false;

        if (!$absolute) {
            $this->sourceDir = dirname($path);
            $path = ROOT . DS . APP_DIR . DS . 'Plugin' . DS . 'Paszport' . DS . WEBROOT_DIR . DS . $path;

        }

        if ($this->sizes = @getimagesize($path)) {
            $this->serverPath = $path;
        }

        return $this;
    }

    /**
     * Resample or resize and cache
     *
     * @param int $start_x ;
     * @param int $start_y ;
     * @param int $width ;
     * @param int $height
     *
     * @return void
     */
    protected function _nativeResize($start_x, $start_y, $width, $height, $method = 'na')
    {
        $cache_dir = dirname($this->serverPath) . DS;
        $cache_path = $cache_dir . implode('_', array(
                $start_x,
                $start_y,
                $width,
                $height,
                $method,
                basename($this->serverPath)
            ));
        if (file_exists($cache_path)) {
            if (@filemtime($cache_path) >= @filemtime($this->serverPath)) { // check if up to date
                $this->_cacheServerPath = $cache_path;
                $this->sizes = @getimagesize($cache_path);
            }
        }
        if (!$this->_cacheServerPath) {
            $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type
            $image = call_user_func('imagecreatefrom' . $types[$this->sizes[2]], $this->serverPath);
            if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor($width, $height))) {
                if (function_exists('imagecolorallocatealpha')) {
                    imagealphablending($temp, false);
                    imagesavealpha($temp, true);
                    $transparent = imagecolorallocatealpha($temp, 255, 255, 255, 127);
                    imagefilledrectangle($temp, 0, 0, $this->sizes[0], $this->sizes[1], $transparent);
                    imagecopyresampled($temp, $image, 0, 0, $start_x, $start_y, $width, $height, $this->sizes[0], $this->sizes[1]);
                } else {
                    imagecolortransparent($temp, imagecolorallocate($temp, 0, 0, 0));
                    imagecopyresampled($temp, $image, 0, 0, $start_x, $start_y, $width, $height, $this->sizes[0], $this->sizes[1]);
                }
            } else {
                $temp = imagecreate($width, $height);
                imagecopyresized($temp, $image, 0, 0, $start_x, $start_y, $width, $height, $this->sizes[0], $this->sizes[1]);
            }
            if (call_user_func("image" . $types[$this->sizes[2]], $temp, $cache_path)) {
                imagedestroy($image);
                imagedestroy($temp);
                $this->_cacheServerPath = $cache_path;
                $this->sizes = @getimagesize($cache_path);
            }
        }
    }

    /**
     * Crop image
     *
     * @param integer $width
     * @param integer $height
     * @param boolean $resize Resize image before croping
     *
     * @return object
     */
    public function crop($width, $height, $resize = true)
    {

        if ($this->_cacheServerPath) {
            $this->source($this->_cacheServerPath, true);
        }
        if ($resize) {
            $ratio_x = $width / $this->sizes[0];
            $ratio_y = $height / $this->sizes[1];
            if (($ratio_y) > ($ratio_x)) {
                $start_x = round(($this->sizes[0] - ($width / $ratio_y)) / 2);
                $start_y = 0;
                $this->sizes[0] = round($width / $ratio_y);
            } else {
                $start_x = 0;
                $start_y = round(($this->sizes[1] - ($height / $ratio_x)) / 2);
                $this->sizes[1] = round($height / $ratio_x);
            }
        } else {
            $start_x = intval(($this->sizes[0] - $width) / 2);
            $start_y = intval(($this->sizes[1] - $height) / 2);
            $this->sizes[0] = $width;
            $this->sizes[1] = $height;
        }
        $this->_nativeResize($start_x, $start_y, $width, $height, 'crop');

        return $this;
    }

    /**
     * Add watermark
     *
     * @param string $watermark_image Watermark PNG image path related to webroot e.g. img/watermark.png
     * @param string $position (center, overlay, more will be added shortly)
     * @param boolean $watermark_absolute_path true if is watermark path server absolute
     *
     * @return object
     */
    public function watermark($watermark_path, $position = 'center', $watermark_absolute_path = false)
    {

        if (!$this->_cacheServerPath) {
            $this->_cacheServerPath = $this->serverPath; // because is first in chain
        }

        $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp");

        $cache_dir = implode(DS, Configure::read('Image2.cacheDir'));
        $cache_dir = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . $cache_dir . DS;
        $cache_path = $cache_dir . Inflector::slug(basename($watermark_path)) . '_' . $position . '_'
            . basename($this->_cacheServerPath);
        if (file_exists($cache_path)) {
            if (@filemtime($cache_path) > @filemtime($this->_cacheServerPath)) { // check if up to date
                $this->_cacheServerPath = $cache_path;

                return $this;
            }
        }

        $watermark = new Image2Helper($this->_View);
        switch ($position) {

            case "center":
                $watermark_width = ceil($this->sizes[0] * 0.7);
                $watermark_height = ceil($this->sizes[1] * 0.7);
                $watermark_x = 5;
                $watermark_y = 5;

                $watermark->source($watermark_path, $watermark_absolute_path)
                    ->resizeit($watermark_width, $watermark_height, true);
                break;

            case "overlay":
                $watermark_width = $this->sizes[0];
                $watermark_height = $this->sizes[1];
                $watermark_x = 0;
                $watermark_y = 0;

                $watermark->source($watermark_path, $watermark_absolute_path)
                    ->resizeit($watermark_width, $watermark_height, false);
                break;

            case "pattern":
                $watermark_width = $this->sizes[0];
                $watermark_height = $this->sizes[1];
                $watermark_x = 0;
                $watermark_y = 0;

                $watermark->source($watermark_path, $watermark_absolute_path)
                    ->crop($watermark_width, $watermark_height, false);
                break;
        }
        $watermark_source = imagecreatefrompng($watermark->_cacheServerPath);
        $original = call_user_func('imagecreatefrom' . $types[$this->sizes[2]], $this->_cacheServerPath);

        imagealphablending($original, true);
        imagealphablending($watermark_source, false);
        imagesavealpha($watermark_source, true);

        imagecopy($original, $watermark_source, $watermark_x, $watermark_y, 0, 0, $watermark->sizes[0], $watermark->sizes[1]);
        if (call_user_func("image" . $types[$this->sizes[2]], $original, $cache_path)) {
            imagedestroy($watermark_source);
            imagedestroy($original);
        }

        $this->_cacheServerPath = $cache_path;
        unset($watermark);

        return $this;
    }

    /**
     * return filename in relative path for
     *
     * @return string
     */
    public function imagePath()
    {
        return ('/paszport/' . $this->sourceDir . '/' . basename($this->_cacheServerPath));
    }

    /**
     * return base64 data iniline image
     *
     * @return string
     */
    public function inlineImage()
    {

        $content = base64_encode(file_get_contents($this->_cacheServerPath));
        $content = 'data:' . $this->sizes['mime'] . ';base64,' . $content;

        return $content;
    }

    /**
     * Automatically resize (crop) an image and returns formatted IMG tag,
     * retained for backward compatibility
     *
     * @param string $path Path to the image file, relative to the webroot/img/ directory.
     * @param integer $width Image of returned image
     * @param integer $height Height of returned image
     * @param string $method resize method (resize, resizeRatio, resizeCrop, crop)
     * @param array $htmlAttributes Array of HTML attributes.
     * @param boolean $return Wheter this method should return a value or output it. This overrides AUTO_OUTPUT. (!!! DEPRECATED, NOT USED)
     * @param string $server_path Local server path to file
     *
     * @return mixed    Either string or echos the value, depends on AUTO_OUTPUT and $return.
     * @access public
     */
    public function resize($path, $width, $height, $method = 'resizeRatio', $htmlAttributes = array(), $return = false, $server_path = false)
    {
        $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type
        if (empty($htmlAttributes['alt'])) {
            $htmlAttributes['alt'] = 'thumb';
        } // Ponemos alt default

        $uploadsDir = 'uploads';

        $fullpath = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . $uploadsDir . DS;
        if (!$server_path) {
            $url = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . $path;
        } else {
            $url = $server_path;
        }

        if (!($size = getimagesize($url))) // $size[0]:width, [1]:height, [2]:type
        {
            return;
        } // image doesn't exist


        switch ($method) {

            case "resizeRatio":
                if (($size[1] / $height) > ($size[0] / $width)) {
                    $width = ceil(($size[0] / $size[1]) * $height);
                } else {
                    $height = ceil($width / ($size[0] / $size[1]));
                }
                $start_x = 0;
                $start_y = 0;
                $method_short = 'rr';
                break;

            case "resize":
                $start_x = 0;
                $start_y = 0;
                $method_short = 'r';
                break;

            case "resizeCrop":
                $ratio_x = $width / $size[0];
                $ratio_y = $height / $size[1];
                if (($ratio_y) > ($ratio_x)) {
                    $start_x = round(($size[0] - ($width / $ratio_y)) / 2);
                    $start_y = 0;
                    $size[0] = round($width / $ratio_y);
                } else {
                    $start_x = 0;
                    $start_y = round(($size[1] - ($height / $ratio_x)) / 2);
                    $size[1] = round($height / $ratio_x);
                }
                $method_short = 'rc';
                break;

            case "crop":
                $start_x = ($size[0] - $width) / 2;
                $start_y = ($size[1] - $height) / 2;
                $size[0] = $width;
                $size[1] = $height;
                $method_short = 'c';
                break;
        }

        $relfile = '/' . $uploadsDir . '/' . $this->cacheDir . '/' . $method_short . '_' . $width . 'x' . $height . '_' . basename($path); // relative file
        $cachefile = $fullpath . $this->cacheDir . DS . $method_short . '_' . $width . 'x' . $height . '_' . basename($path); // location on server

        if (file_exists($cachefile)) {
            $csize = getimagesize($cachefile);
            $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
            if (@filemtime($cachefile) < @filemtime($url)) { // check if up to date
                $cached = false;
            }
        } else {
            $cached = false;
        }

        if (!$cached) {
            $image = call_user_func('imagecreatefrom' . $types[$size[2]], $url);
            if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor($width, $height))) {
                imagecolortransparent($temp, imagecolorallocate($temp, 0, 0, 0));
                imagecopyresampled($temp, $image, 0, 0, $start_x, $start_y, $width, $height, $size[0], $size[1]);
            } else {
                $temp = imagecreate($width, $height);
                imagecopyresized($temp, $image, 0, 0, $start_x, $start_y, $width, $height, $size[0], $size[1]);
            }
            call_user_func("image" . $types[$size[2]], $temp, $cachefile);
            imagedestroy($image);
            imagedestroy($temp);
        } else {
            //copy($url, $cachefile);
        }

        return $this->Html->image($relfile, $htmlAttributes);
    }

}

?>