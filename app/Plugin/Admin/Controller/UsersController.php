<?php

App::uses('AdminAppController', 'Admin.Controller');

class UsersController extends AdminAppController {

    public $uses = array('Admin.AdminUser');
    private static $perPage = 20;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'users');
    }

    public function index() {
        $page = isset($this->request->query['page']) ?
            (int) $this->request->query['page'] : 0;

        $q = isset($this->request->query['q']) ?
            $this->request->query['q'] : false;

        $conditions = array();
        if($q) {
            $conditions['or'] = array(
                array('id LIKE' => "%$q%"),
                array('email LIKE' => "%$q%"),
                array('username LIKE' => "%$q%"),
            );
            $this->set('q', $q);
        }

        $count = $this->AdminUser->find('count', array(
            'conditions' => $conditions
            )
        );

        $this->set('page', $page);
        $this->set('pages', ceil($count / self::$perPage));
        $this->set('rows', $this->AdminUser->find('all', array(
            'fields' => 'id, email, created, logged_at, username',
            'conditions' => $conditions,
            'order' => 'created DESC',
            'limit' => self::$perPage,
            'offset' => $page * self::$perPage
        )));
    }

    public function login($id) {
        $user = $this->AdminUser->find('first', array(
            'conditions' => array(
                'id' => $id
            )
        ));

        if(!$user)
            throw new NotFoundException;

        $this->Auth->login($user['AdminUser']);
        $this->redirect('/');
    }

}