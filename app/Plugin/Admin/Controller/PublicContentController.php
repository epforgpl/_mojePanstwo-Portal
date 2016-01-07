<?php

App::uses('AdminAppController', 'Admin.Controller');

class PublicContentController extends AdminAppController {

    public static $perPage = 20;
    public static $types = array(
        'letters' => array(
            'label' => 'Pisma',
            'model' => 'AdminLetter',
            'url' => '/dane/pisma',
        ),
        'collections' => array(
            'label' => 'Kolekcje',
            'model' => 'AdminCollection',
            'url' => '/dane/kolekcje'
        ),
    );

    public static $defaultType = 'letters';
    public $type;

    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $type = self::$defaultType;
        if(isset($this->request->query['type']) &&
            array_key_exists($this->request->query['type'], self::$types))
            $type = $this->request->query['type'];

        $this->type = self::$types[$type];
        $this->set('type', $type);
        $this->set('typeOptions', $this->type);
        $this->set('types', self::$types);
        $this->set('action', 'public_content');
    }

    public function index() {
        $this->loadModel('Admin.' . $this->type['model']);
        $page = isset($this->request->query['page']) ?
            (int) $this->request->query['page'] : 0;

        $conditions = array('is_public' => '1');
        $count = $this->{$this->type['model']}->find('count', array(
            'conditions' => $conditions)
        );

        $this->set('page', $page);
        $this->set('pages', ceil($count / self::$perPage));
        $this->set('rows', $this->{$this->type['model']}->find('all', array(
            'fields' => 'id, name, created_at, is_public, is_promoted',
            'conditions' => $conditions,
            'order' => 'created_at DESC',
            'limit' => self::$perPage,
            'offset' => $page * self::$perPage
        )));
    }

    public function promote() {
        $success = false;
        if(isset($this->request->query['type']) &&
            isset($this->request->query['id']) &&
            isset($this->request->query['is_promoted']) &&
            array_key_exists($this->request->query['type'], self::$types)) {
            $type = self::$types[$this->request->query['type']];
            $this->loadModel('Admin.' . $type['model']);
            $success = $this->{$type['model']}->save(array(
                'id' => (int) $this->request->query['id'],
                'is_promoted' => (int) $this->request->query['is_promoted']
            ));
        }

        $this->setSerialized('success', $success);
    }

}
