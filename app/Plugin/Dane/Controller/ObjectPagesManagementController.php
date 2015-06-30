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
        if($this->ObjectPagesManagement->setCover($this->data['credits'])) {
            $this->saveImage('cover', 'jpg', $this->data['image']);
            $success = true;
        }

        $this->setResponse($success);
    }

    public function deleteCover() {
        $this->ObjectPagesManagement->deleteCover();
        $this->deleteImage('cover', 'jpg');
    }

    private function deleteImage($type, $ext) {
        $this->setResponse(
            $this->S3->deleteObject(
                S3Component::$bucket,
                'pages/'. $type .'/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '.' .$ext
            )
        );
    }

    private function saveImage($type, $ext, $base64) {
        $base64 = explode(',', $base64);
        $data = base64_decode($base64[1]);

        return $this->S3->putObject(
            $data,
            S3Component::$bucket,
            'pages/'. $type .'/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '.' .$ext,
            S3::ACL_PUBLIC_READ,
            array(),
            array('Content-Type' => 'image/' . $ext)
        );
    }

    private function setResponse($response) {
        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }

}