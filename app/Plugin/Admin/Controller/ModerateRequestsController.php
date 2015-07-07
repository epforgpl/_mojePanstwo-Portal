<?php

App::uses('AdminAppController', 'Admin.Controller');

class ModerateRequestsController extends AdminAppController {

    public $uses = array('Admin.PageRequest');

    public function index() {
        $pages_requests = $this->PageRequest->find('all', array(
            'fields' => array('PageRequest.*', 'User.id', 'User.username'),
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => array(
                        'User.id = PageRequest.user_id'
                    )
                )
            ),
            'conditions' => array(
                'PageRequest.status' => '0'
            )
        ));

        $this->set('pages_requests', $pages_requests);
    }

    public function accept($id, $role) {
        $this->PageRequest->accept($id, $role);
        $this->redirect($this->referer());
    }

    public function reject($id) {
        $this->PageRequest->updateAll(array(
            'status' => '2'
        ), array(
            'PageRequest.id' => $id
        ));

        $this->redirect($this->referer());
    }

}