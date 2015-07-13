<?php

class LogsController extends PaszportAppController
{
    public $helpers = array('Paginator', 'Time');
    public $components = array('Paszport.PassportApi');

    public function index()
    {
        $this->data = $this->PassportApi->find('logs', array(
            'conditions' => array('Log.user_id' => $this->Auth->user('id')),
            'limit' => 30
        ), 'all');
        $this->data = $this->data['log'];
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_LOGS', true));
    }
}