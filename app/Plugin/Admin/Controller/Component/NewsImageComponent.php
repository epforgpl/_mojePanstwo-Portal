<?php

App::uses('Component', 'Controller');

class NewsImageComponentException extends Exception {}

class NewsImageComponent extends Component {

    public $components = array('S3');

    private static $sizes = array(
        '0' => true,
        '1' => array(250, 150),
        '2' => array(640, 410),
        '3' => array(900, 576)
    );

    private static $path = "ngo_konkursy/%d_%d.jpg";
    private static $allowedExtensions = array('jpg', 'jpeg', 'png');
    private static $s3 = 'http://sds.tiktalik.com';

    public function upload($image, $id) {
        $ext = end(explode('.', $image['name']));
        $content = file_get_contents($image['tmp_name']);

        if(!in_array($ext, self::$allowedExtensions))
            throw new NewsImageComponentException(
                __('Nieprawidłowe rozszerzenie pliku ('. $ext .')')
            );

        $fullSizeImage = $this->S3->putObject(
            $content, S3Component::$bucket, sprintf(self::$path, $id, '0'),
            S3::ACL_PUBLIC_READ,
            array(), array('Content-Type' => $image['type'])
        );

        if(!$fullSizeImage)
            throw new NewsImageComponentException(
                __('Wystąpił błąd podczas wgrywania pliku na chmurę')
            );

        if(!@file_put_contents(
            APP . 'tmp/' . $id . '_0.' . $ext,
            file_get_contents(self::$s3 . '/' . S3Component::$bucket . '/' . sprintf(self::$path, $id, '0'))
        ))
            throw new NewsImageComponentException(
                __('Wystąpił błąd podczas tworzenia pliku tymczasowego')
            );

        list($fullWidth, $fullHeight) = getimagesize(APP . 'tmp/' . $id . '_0.' . $ext);

        foreach(self::$sizes as $s => $size) {
            if($size === true)
                continue;

            $width = $size[0];
            $height = $size[1];

            if($fullWidth >= $width && $fullHeight >= $height) {
                exec('convert '. APP . 'tmp/' . $id . '_0.' . $ext . ' -resize "'. $width . 'x' . $height . '^" -gravity center -crop '. $width . 'x' . $height . '+0+0 +repage '. APP . 'tmp/' . $id . '_' . $s . '.' . $ext);
            } else {
                exec('convert '. APP . 'tmp/' . $id . '_0.' . $ext . ' -resize "'. $width . 'x' . $height . '" -gravity center -background white -extent '. $width . 'x' . $height . ' '. APP . 'tmp/' . $id . '_' . $s . '.' . $ext);
            }

            $resizedImage = $this->S3->putObject(
                file_get_contents(APP . 'tmp/' . $id . '_' . $s . '.' . $ext),
                S3Component::$bucket, sprintf(self::$path, $id, $s),
                S3::ACL_PUBLIC_READ,
                array(), array('Content-Type' => $image['type'])
            );

            if(!$resizedImage)
                throw new NewsImageComponentException(
                    __('Wystąpił błąd podczas wgrywania obrazka o rozmiarze '.$width.'x'.$height.' na chmurę')
                );
        }

        foreach(self::$sizes as $s => $size)
            @unlink(APP . 'tmp/' . $id . '_'. $s . '.' . $ext);
    }

    public function remove($id) {
        foreach(self::$sizes as $s => $size)
            $this->S3->deleteObject(S3Component::$bucket, sprintf(self::$path, $id, $s));
    }

}