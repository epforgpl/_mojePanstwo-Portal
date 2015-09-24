<?php

App::uses('StartAppController', 'Start.Controller');

class CollectionsController extends StartAppController {

    public $uses = array('Collections.Collection');
    public $chapter_selected = 'collections';
    public $appSelected = 'kolekcje';

    public function index() {
        $this->title = 'Moje Kolekcje';

        $this->loadDatasetBrowser('kolekcje', array(
            'conditions' => array(
                'dataset' => 'kolekcje',
                'kolekcje.user_id' => $this->Auth->user('id'),
            ),
            'aggsPreset' => null,
            'aggs' => array(),
            'beforeBrowserElement' => 'Start.collectionsBefore',
            'afterBrowserElement' => 'Start.collectionsAfter'
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

    public function edit($id) {
        if(count($this->request->data)) {
            $results = $this->Collection->edit($id, $this->request->data);
            if(isset($results['Collection'])) {
                $message = 'Kolekcja została poprawnie zapisana';
            } elseif(is_array($results)) {
                $errors = reset(array_values($results));
                $message = $errors[0];
            } else {
                $message = 'Wystąpił błąd';
            }

            $this->Session->setFlash($message);
        }

        $this->loadModel('Dane.Dataobject');
        $item = $this->Dataobject->find('first', array(
            'conditions' => array(
                'dataset' => 'kolekcje',
                'id' => $id,
                'kolekcje.user_id' => $this->Auth->user('id'),
            ),
        ));

        if(!$item)
            throw new NotFoundException;

        $this->title = $item->getTitle();
        $this->set('item', $item);
    }

    public function view($id) {
        if(count($this->request->data)) {
            $this->Collection->delete($id);
            $this->Session->setFlash('Kolekcja została poprawnie usunięta');
            $this->redirect('/moje-kolekcje');
        }

		$this->loadModel('Dane.Dataobject');
		$item = $this->Dataobject->find('first', array(
			'conditions' => array(
				'dataset' => 'kolekcje',
				'id' => $id,
				'kolekcje.user_id' => $this->Auth->user('id'),
			),
		));

        if(!$item)
            throw new NotFoundException;

        $this->Components->load('Dane.DataBrowser', array(
	        'conditions' => array(
		        'collection_id' => $id,
	        ),
        ));

        $this->title = $item->getTitle();
		$this->set('item', $item);
    }

}
