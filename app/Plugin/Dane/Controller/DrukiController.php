<?php

class DrukiController extends AppController {

    public $uses = array('PrzejrzystyKrakow.Glosy');
    public $components = array('RequestHandler');

    public function vote() {
        $this->set('response', $this->Glosy->vote(
            (int) $this->request->params['object_id'],
            $this->data
        ));

        $this->set('_serialize', array('response'));
    }

    public function getVotes() {
        $this->set('response', $this->Glosy->getVotes(
            (int) $this->request->params['object_id']
        ));

        $this->set('_serialize', array('response'));
    }

}