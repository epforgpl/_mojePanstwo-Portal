<?php

App::uses('AdminAppController', 'Admin.Controller');

class ModerateRequestsController extends AdminAppController {

    public $uses = array('Admin.PageRequest');

    private $statuses = array(
        'Nowe',
        'Zaakceptowane',
        'Odrzucone'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'moderate_requests');
    }

    public function index($status = 0)
    {
        if(!isset($this->statuses[$status]))
            throw new NotFoundException;

        $statuses_count = array();
        foreach($this->statuses as $status => $name) {
            $statuses_count[$status] = $this->PageRequest->find('count', array(
                'conditions' => array(
                    'PageRequest.status' => $status
                )
            ));
        }

        $pages_requests = $this->PageRequest->find('all', array(
            'fields' => array('PageRequest.*', 'User.id', 'User.username'),
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'User.id = PageRequest.user_id'
                    )
                )
            ),
            'conditions' => array(
                'PageRequest.status' => $status
            )
        ));

        $this->set('statuses_count', $statuses_count);
        $this->set('statuses', $this->statuses);
        $this->set('status', $status);
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
