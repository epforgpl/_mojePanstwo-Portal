<?php

App::uses('AppController', 'Controller');

class TwitterController extends AppController {

    public $components = array('RequestHandler');
    public $uses = array('Media.TwitterAccountSuggestion');

    public function suggestNewAccount() {
        $this->set('response', $this->TwitterAccountSuggestion->suggestNewAccount($this->request->data));
        $this->set('_serialize', array('response'));
    }

}
