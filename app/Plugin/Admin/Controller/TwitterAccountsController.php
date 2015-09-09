<?php

App::uses('AdminAppController', 'Admin.Controller');

class TwitterAccountsController extends AdminAppController {

    public $uses = array('Admin.TwitterAccountSuggestion', 'Admin.TwitterAccount');

    private $types = array(
        '2' => 'Komentator',
        '3' => 'Urząd',
        '7' => 'Polityk',
        '8' => 'Partia',
        '9' => 'NGO'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'twitter_accounts');
    }

    public function index() {
        $suggestions = $this->TwitterAccountSuggestion->find('all', array(
            'fields' => array('TwitterAccountSuggestion.*', 'User.id', 'User.username'),
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'User.id = TwitterAccountSuggestion.user_id'
                    )
                )
            )
        ));

        $this->set('types', $this->types);
        $this->set('suggestions', $suggestions);
    }

    public function add($id) {
        if(!array_key_exists($this->request->data['type'], $this->types))
            throw new NotFoundException;

        $data = $this->TwitterAccountSuggestion->find('first', array(
            'fields' => array('TwitterAccountSuggestion.name', 'TwitterAccountSuggestion.type_id'),
            'conditions' => array(
                'TwitterAccountSuggestion.id' => $id
            )
        ));

        if($name = @$data['TwitterAccountSuggestion']['name']) {
            $this->TwitterAccount->save(array(
                'twitter_name' => $name,
                'typ_id' => (int) $this->request->params['type']
            ));

            $this->TwitterAccountSuggestion->delete($id);
        }

        $this->redirect($this->referer());
    }

    public function remove($id) {
        $this->TwitterAccountSuggestion->delete($id);
        $this->redirect($this->referer());
    }

}
