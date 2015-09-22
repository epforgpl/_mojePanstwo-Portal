<?php

App::uses('AppController', 'Controller');

/**
 * @property Collection Collection
 */
class CollectionsController extends AppController {

    public $components = array('RequestHandler');
    public $uses = array('Collections.Collection');

    public function beforeFilter() {
        parent::beforeFilter();

        if(!$this->Auth->user())
            throw new ForbiddenException;
    }

    public function get() {
        $this->set('response', $this->Collection->get());
        $this->set('_serialize', array('response'));
    }

    public function create() {
        $this->set('response', $this->Collection->create($this->request->data));
        $this->set('_serialize', array('response'));
    }

}
