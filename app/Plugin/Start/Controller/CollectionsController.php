<?php

App::uses('StartAppController', 'Start.Controller');

class CollectionsController extends StartAppController
{

    public $uses = array('Collections.Collection', 'Dane.ObjectUsersManagement');
    public $components = array('RequestHandler');
    public $chapter_selected = 'collections';
    public $appSelected = 'kolekcje';

    public function index()
    {
        $this->title = 'Moje Kolekcje';

        $this->set('objects', $this->ObjectUsersManagement->getUserObjects());

        $this->Components->load('Dane.DataBrowser', array(
            '_type' => 'collections'
        ));
    }

    public function add()
    {
        $this->title = 'Dodaj Kolekcje';
        $id = 0;

        if (count($this->request->data)) {
            $results = $this->Collection->create($this->request->data);
            if (isset($results['Collection'])) {
                $message = 'Kolekcja została poprawnie dodana';
                $id = (int) $results['Collection']['id'];
            } elseif (is_array($results)) {
                $errors = reset(array_values($results));
                $message = $errors[0];
            } else {
                $message = 'Wystąpił błąd';
            }

            $this->Session->setFlash($message);
        }

        $this->redirect('/moje-kolekcje' . ($id > 0 ? '/' . $id : ''));
    }

    public function edit($id)
    {
        if (count($this->request->data)) {
            $results = $this->Collection->edit($id, $this->request->data);
            $class = "alert-info";

            if (isset($results['Collection'])) {
                $message = 'Kolekcja została poprawnie zapisana';
                $class = "alert-success";
            } elseif (is_array($results)) {
                $errors = reset(array_values($results));
                $message = $errors[0];
                $class = "alert-error";
            } else {
                $message = 'Wystąpił błąd';
                $class = "alert-error";
            }

            $this->Session->setFlash($message, null, array('class' => $class));
        }

        $this->loadModel('Dane.Dataobject');
        $item = $this->Dataobject->find('first', array(
            'conditions' => array(
                'dataset' => 'kolekcje',
                'id' => $id,
                'kolekcje.user_id' => $this->Auth->user('id'),
            ),
        ));

        if (!$item)
            throw new NotFoundException;

        $this->title = $item->getTitle();
        $this->set('item', $item);
    }

    public function view($id)
    {
        if (count($this->request->data)) {
            if(isset($this->request->data['is_public'])) {
                $results = $this->Collection->edit($id, $this->request->data);
                $class = "alert-info";
                $is_public = $this->request->data['is_public'];
                if($is_public) {
                    $this->Collection->publish($id);
                } else {
                    $this->Collection->unpublish($id);
                }

                if (isset($results['Collection'])) {
                    $message = 'Kolekcja została poprawnie zapisana';
                    $class = "alert-success";
                } elseif (is_array($results)) {
                    $errors = reset(array_values($results));
                    $message = $errors[0];
                    $class = "alert-error";
                } else {
                    $message = 'Wystąpił błąd';
                    $class = "alert-error";
                }

                $this->Session->setFlash($message, null, array('class' => $class));
            } else {
                $this->Collection->delete($id);
                $this->Session->setFlash('Kolekcja została poprawnie usunięta', null, array('class' => 'alert-success'));
                $this->redirect('/moje-kolekcje');
            }
        }

        $item = $this->Collection->load($id);
        if (!$item)
            throw new NotFoundException;

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'collection_id' => $id,
            ),
        ));

        $this->title = $item->getTitle();
        $this->set('item', $item);
    }

    public function publish($id) {
        $this->set('response', $this->Collection->publish($id));
        $this->set('_serialize', array('response'));
    }

    public function unpublish($id) {
        $this->set('response', $this->Collection->unpublish($id));
        $this->set('_serialize', array('response'));
    }
    
    public function inner_post() {
	    
	    $response = false;
	    
	    if(
		    @$this->request->params['collection_id'] && 
		    @$this->request->params['object_id'] &&
		    @$this->request->data['_action']
	    ) {
		    
		    if( $this->request->data['_action'] == 'edit' ) {
			    
			    $data = array();
			    
			    if( isset($this->request->data['note']) )
			    	$data['note'] = $this->request->data['note'];
			    
			    $response = $this->Collection->editObject($this->request->params['collection_id'], $this->request->params['object_id'], $data);
			    
		    } elseif($this->request->data['_action'] == 'delete') {

                $response = $this->Collection->removeObject($this->request->params['collection_id'], $this->request->params['object_id']);
                $this->redirect('/moje-kolekcje/' . $this->request->params['collection_id']);
            }
		    
		}
	    	    
	    $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

}
