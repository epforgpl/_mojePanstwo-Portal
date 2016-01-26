<?php

App::uses('AdminAppController', 'Admin.Controller');

class TransactionsController extends AdminAppController
{

    public $uses = array('Admin.AdminTransaction');
    public $components = array('RequestHandler');
    private static $perPage = 20;

    private static $statusDict = array(
        '' => 'Nie potwierdzona',
        'TRUE' => 'Poprawna',
        'FALSE' => 'Błędna'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'transactions');
        $this->set('statusDict', self::$statusDict);
    }

    public function index()
    {
        if(isset($this->request->data['id'])) {
            $results = $this->AdminTransaction->save(
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
                array('id LIKE' => "%$q%")
            );
            $this->set('q', $q);
        }

        $count = $this->AdminTransaction->find('count', array(
                'conditions' => $conditions
            )
        );

        $this->set('page', $page);
        $this->set('pages', ceil($count / self::$perPage));
        $this->set('rows', $this->AdminTransaction->find('all', array(
            'fields' => 'id, krs_pozycje_id, user_id, form_send_at, res_received_at, amount, email, surname, firstname, res_status, is_transferred',
            'conditions' => $conditions,
            'order' => 'form_send_at DESC',
            'limit' => self::$perPage,
            'offset' => $page * self::$perPage
        )));
    }

}