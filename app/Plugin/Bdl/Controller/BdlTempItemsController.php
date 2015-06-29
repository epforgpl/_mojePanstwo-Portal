<?php

App::uses('ApplicationsController', 'Controller');

class BdlTempItemsController extends ApplicationsController
{

    public $components = array('RequestHandler');
	
	public $settings = array(
        'id' => 'bdl',
        'title' => 'Bdl',
        'subtitle' => 'Dane statystyczne o Polsce',
    );
	
    public function index()
    {
        $BdlTempItems = $this->BdlTempItem->find('all');
        $this->set(array(
            'BdlTempItems' => $BdlTempItems,
            '_serialize' => array('BdlTempItems')
        ));
    }

    public function view($id)
    {
        $BdlTempItem = $this->BdlTempItem->findById($id);
        $this->set(array(
            'BdlTempItem' => $BdlTempItem,
            '_serialize' => array('BdlTempItem'),
            'id'=> $id
        ));
    }

    public function add()
    {
        $this->BdlTempItem->create();
        if ($this->BdlTempItem->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));

        $this->redirect($this->referer());
    }

    public function edit($id)
    {
        $this->BdlTempItem->id = $id;
        if ($this->BdlTempItem->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));

        $this->redirect($this->referer());
    }

    public function delete($id)
    {
        if ($this->BdlTempItem->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));

        $this->redirect($this->referer());
    }

    public function addIngredient($item_id = false)
    {


    }
    
    public function getMenu() {
	    
	    $menu = array(
		    'items' => array(
			    array(
				    'id' =>'',
				    'label' => 'Wskaźniki',
				    'icon' => array(
					    'src' => 'glyphicon',
					    'id' => 'home',
				    ),
			    ),
		    ),
		    'base' => '/bdl',
	    );
	    
	    if( $this->hasUserRole('3') ) {
		    
		    $menu['items'][] = array(
			    'id' => 'bdl_temp_items',
			    'label' => 'Tworzenie wskaźników',
		    );
		    
	    }
	    
	    if( count($menu['items'])===1 )
	    	return array();
	    else 
	    	return $menu;	    
	    
    }
}