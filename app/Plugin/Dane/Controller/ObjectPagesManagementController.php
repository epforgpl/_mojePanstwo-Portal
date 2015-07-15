<?php

class ObjectPagesManagementController extends AppController {

    public $uses = array('Dane.ObjectPagesManagement', '');
    public $components = array('RequestHandler', 'S3');

    public function __construct($request, $response) {
        parent::__construct($request, $response);

        $this->ObjectPagesManagement->setRequest($request);
        if(!$this->ObjectPagesManagement->isEditable())
            throw new ForbiddenException;
    }

    public function setLogo() {
        $success = false;
        if($this->saveImage('logo', 'png', $this->data)) {
            $this->ObjectPagesManagement->setLogo();
            $success = true;
        }

        $this->setResponse($success);
    }

    public function deleteLogo() {
        $this->ObjectPagesManagement->deleteLogo();
        $this->deleteImage('logo', 'png');
    }

    public function setCover() {
        if($success = $this->ObjectPagesManagement->setCover($this->data['credits'])) {
            $this->saveImage('cover', 'jpg', $this->data);
        }

        $this->setResponse($success);
    }

    public function deleteCover() {
        $this->ObjectPagesManagement->deleteCover();
        $this->deleteImage('cover', 'jpg');
    }

    private function deleteImage($type, $ext) {

        $this->S3->deleteObject(
            S3Component::$bucket,
            'pages/original/'. $type .'/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '.' .$ext
        );

        $this->setResponse(
            $this->S3->deleteObject(
                S3Component::$bucket,
                'pages/'. $type .'/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '.' .$ext
            )
        );
    }

    private function saveImage($type, $ext, $data) {
        $image = $data['image'];
        $position = $data['pos'];
        $zoom = ((float) $data['zoom']) * 100;
        $src = 'pages/'. $type .'/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '.' .$ext;
        $tmp_src = APP . 'tmp/' . $this->request['object_id'] . '.' .$ext;
        $tmp_src_zoom = APP . 'tmp/' . $this->request['object_id'] . '_zoom.' .$ext;
        $tmp_src_crop = APP . 'tmp/' . $this->request['object_id'] . '_crop.' .$ext;

        $data = explode(',', $image);
        if(!count($data))
            return false;

        $decoded = base64_decode($data[1]);

        $object = $this->S3->putObject(
            $decoded,
            S3Component::$bucket,
            'original/'.$src,
            S3::ACL_PUBLIC_READ,
            array(),
            array('Content-Type' => 'image/' . $ext)
        );

        if(!$object)
            return false;

        $tmp_image = file_put_contents($tmp_src, file_get_contents('http://sds.tiktalik.com/portal/original/' . $src));
        if(!$tmp_image)
            return false;

        if($type == 'cover') {
            $zoom *= 2;
            $position['x'] = (int) $position['x'] * 2;
            $position['y'] = (int) $position['y'] * 2;
        }

        exec("convert $tmp_src -resize $zoom% $tmp_src_zoom");

        if($type == 'logo') {
            $width = 180;
            $height = 180;
        } else {
            $width = 1500;
            $height = 300;
        }

        $x = (int) $position['x'];
        $x = $x >= 0 ? '-' . $x : '+' . (-$x);
        $y = (int) $position['y'];
        $y = $y >= 0 ? '-' . $y : '+' . (-$y);

        exec("convert $tmp_src_zoom -crop {$width}x{$height}{$x}{$y}\! -background white -flatten $tmp_src_crop");

        $crop_image = file_get_contents($tmp_src_crop);

        $object = $this->S3->putObject(
            $crop_image,
            S3Component::$bucket,
            $src,
            S3::ACL_PUBLIC_READ,
            array(),
            array('Content-Type' => 'image/' . $ext)
        );

        unlink($tmp_src_crop);
        unlink($tmp_src_zoom);
        unlink($tmp_src);

        return true;
    }

    private function setResponse($response) {
        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }

}