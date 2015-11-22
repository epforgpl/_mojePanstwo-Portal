<?php

App::uses('ApplicationsController', 'Controller');

class BDLWskaznikiController extends ApplicationsController
{

    public $components = array('RequestHandler');
    public $appSelected = 'bdl';
	
	public $settings = array(
        'id' => 'bdl-admin',
        'title' => 'BDL Admin',
    );
	
    public function index()
    {
        $this->title = 'Opisane wskaźniki BDL';

        $this->loadDatasetBrowser('bdl_wskazniki', array(
	        'conditions' => array(
		        'dataset' => 'bdl_wskazniki',
		        'bdl_wskazniki.opis!=' => '',
	        ),
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
                $this->log($response);
                $this->redirect('/moje-kolekcje/' . $this->request->params['collection_id']);
            }
		    
		}
	    	    
	    $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    
    public function getChapters() {
								
		$items = array(
			array(
				'id' => 'index',
				'label' => 'Opisane wskaźniki BDL',
				'href' => '/' . $this->settings['id'],
			)
		);
							
		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);
				
		return $output;
		
	}

}
