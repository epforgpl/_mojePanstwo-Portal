<?php

App::uses('AdminAppController', 'Admin.Controller');

class BankAccountsController extends AdminAppController
{

    public $uses = array('Admin.KrsBankAccount');
    public $components = array('RequestHandler');
    private static $perPage = 20;

    private static $statusDict = array(
        'Oczekuje',
        'Zaakceptowano',
        'Odrzucono'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'bank_accounts');
        $this->set('statusDict', self::$statusDict);
    }

    public function index() {
        if(isset($this->request->data['id'])) {
            $results = $this->KrsBankAccount->save(
                $this->request->data
            );

            $msg = $results ? 'Zmiany zostały poprawnie zapisane' : 'Wystąpił błąd';
            $this->Session->setFlash($msg, 'default');
            $this->redirect('/' . $this->request->url);
        }

        $page = isset($this->request->query['page']) ?
            (int) $this->request->query['page'] : 0;

        $q = isset($this->request->query['q']) ?
            $this->request->query['q'] : false;

        $conditions = array();
        if($q) {
            $conditions['or'] = array(
                array('krs_pozycje_id LIKE' => "%$q%"),
                array('bank_account LIKE' => "%$q%"),
            );
            $this->set('q', $q);
        }

        $count = $this->KrsBankAccount->find('count', array(
                'conditions' => $conditions
            )
        );

        $this->set('page', $page);
        $this->set('pages', ceil($count / self::$perPage));
        $this->set('rows', $this->KrsBankAccount->find('all', array(
            'fields' => 'id, krs_pozycje_id, user_id, bank_account, status, created_at, updated_at',
            'conditions' => $conditions,
            'order' => 'created_at DESC',
            'limit' => self::$perPage,
            'offset' => $page * self::$perPage
        )));
    }

}