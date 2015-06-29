<?php

class BdlTempItemsController extends AppController
{

    public $components = array('RequestHandler');

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
        debug($_SERVER['REQUEST_METHOD']);

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
        debug($this->request->data);

        die();
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
}