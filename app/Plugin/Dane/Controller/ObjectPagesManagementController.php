<?php

class ObjectPagesManagementController extends AppController {

    public $uses = array('Dane.ObjectPagesManagement');
    public $components = array('RequestHandler');

    public function __construct($request, $response) {
        parent::__construct($request, $response);

        $this->ObjectPagesManagement->setRequest($request);
        if(!$this->ObjectPagesManagement->isEditable())
            throw new ForbiddenException;
    }

    public function setLogo() {
        $success = false;
        if($this->saveImage('logo', 'png', $this->data['image'])) {
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
        $success = false;
        if($this->ObjectPagesManagement->setCover()) {
            $this->saveImage('cover', 'jpg', $this->data['image']);
            $success = true;
        }

        $this->setResponse($success);
    }

    public function deleteCover() {
        $this->ObjectPagesManagement->deleteCover();
        $this->deleteImage('cover', 'jpg');
    }

    private function createDir($type) {
        $path = APP . 'webroot/pages/' . $type . '/' . $this->request['dataset'];
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    private function getSrc($type, $ext) {
        $this->createDir($type);
        return APP . 'webroot/pages/' . $type . '/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '.'. $ext;
    }

    private function deleteImage($type, $ext) {
        $src = $this->getSrc($type, $ext);
        $success = unlink($src);

        $this->setResponse($success);
    }

    private function saveImage($type, $ext, $base64) {
        $src = $this->getSrc($type, $ext);
        $sizeInBytes = (int) ((strlen($base64) - 814) / 1.37);
        $base64 = explode(',', $base64);
        $data = base64_decode($base64[1]);
        $image = imagecreatefromstring($data);
        $success = false;

        if($sizeInBytes < 2500000) {
            switch ($ext) {
                case 'png':
                    $success = imagepng($image, $src);
                break;

                case 'jpg':
                    $success = imagejpeg($image, $src);
                break;
            }
        }

        return $success;
    }

    private function setResponse($response) {
        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }

}