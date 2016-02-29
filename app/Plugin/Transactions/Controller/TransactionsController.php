<?php

App::uses('AppController', 'Controller');

class TransactionsController extends AppController
{
    public $uses = array('Transactions.Transaction');

    public function formSubmitAction()
    {
        $results = $this->Transaction->save($this->request->data);
        if(isset($results['redirect'])) {
            $this->redirect($results['redirect']);
        } else {
            $this->Session->setFlash('Wystąpił błąd');
            $this->redirect('/');
        }
    }

    public function getTransactionStatus() {
        $results = $this->Transaction->save($this->request->data);
        if($results['transaction']) {
            $this->autoRender = false;
            echo "TRUE";
        } else
            throw new BadRequestException;
    }

    public function results($id) {
        $results = $this->Transaction->get($id);
        $transaction = false;
        if(isset($results['Transaction']))
            $transaction = $results;
        $this->set('transaction', $transaction);
    }

}