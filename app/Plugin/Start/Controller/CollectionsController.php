<?php

App::uses('StartAppController', 'Start.Controller');

class CollectionsController extends StartAppController {

    public $uses = array('Collections.Collection');
    public $chapter_selected = 'collections';

    public function index() {
        $this->title = 'Moje Kolekcje';

        $this->loadDatasetBrowser('kolekcje', array(
            'conditions' => array(
                'dataset' => 'kolekcje',
                'kolekcje.user_id' => $this->Auth->user('id'),
            ),
            'aggsPreset' => null,
            'aggs' => array(),
            'beforeBrowserElement' => 'Start.kolekcje',
        ));
    }

    public function add() {
        $this->title = 'Dodaj Kolekcje';

        if(count($this->request->data)) {
            $results = $this->Collection->create($this->request->data);
            if(isset($results['Collection'])) {
                $message = 'Kolekcja została poprawnie dodana';
            } elseif(is_array($results)) {
                $errors = reset(array_values($results));
                $message = $errors[0];
            } else {
                $message = 'Wystąpił błąd';
            }

            $this->Session->setFlash($message);
        }
    }

}
