<?php

App::uses('AppController', 'Controller');

class TransactionsController extends AppController {

    public $components = array('RequestHandler');
    public $uses = array('Transactions.Transaction');

    public function formSubmitAction() {
        $res = $this->Transaction->save($this->request->data);

        if(isset($res['error_message']) && isset($this->request->data['krs_pozycje_id'])) {
            $this->Session->setFlash($res['error_message'], 'default');
            $this->redirect('/dane/krs_podmioty/' . $this->request->data['krs_pozycje_id']);
        } elseif(isset($res['redirect'])) {
            $this->redirect($res['redirect']);
        } else
            throw new BadRequestException;
    }

    public function getTransactionStatus() {
        if($this->request->clientIp() == '195.149.229.109') {
            $this->autoRender = false;
            $this->Transaction->save($this->request->data);
            echo 'TRUE';
        } else
            throw new NotFoundException;
    }

    public function results($transaction_id = 0) {
        $transaction = $this->Transaction->get($transaction_id);
        if(!$transaction)
            throw new NotFoundException;

        $this->set('transaction', $transaction);
    }

}