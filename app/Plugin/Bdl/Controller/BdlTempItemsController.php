<?php

class BdlTempItemsController extends AppController {

    public $components = array('RequestHandler');

    public function index() {
        $BdlTempItems = $this->BdlTempItem->find('all');
        $this->set(array(
            'BdlTempItems' => $BdlTempItems,
            '_serialize' => array('BdlTempItems')
        ));
    }

    public function view($id) {
        $BdlTempItem = $this->BdlTempItem->findById($id);
        $this->set(array(
            'BdlTempItem' => $BdlTempItem,
            '_serialize' => array('BdlTempItem')
        ));
    }

    public function add() {
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
    }

    public function edit($id) {
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
    }

    public function delete($id) {
        if ($this->BdlTempItem->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
    
    public function addIngredient($item_id = false) {
	    
	    
	    
    }
}