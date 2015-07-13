<?php

class DatalinerController extends DaneAppController
{

    public $components = array('RequestHandler');

    public function index()
    {

        $data = $this->Dataliner->index(array(
            'conditions' => isset($this->request->query['conditions']) ? $this->request->query['conditions'] : array(),
            'page' => isset($this->request->query['page']) ? $this->request->query['page'] : 1,
        ));

        $this->set('data', $data);
        $this->set('_serialize', 'data');

    }

}