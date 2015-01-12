<?php

class SzablonyController extends AppController
{

    public $components = array('RequestHandler');
    public $uses = array('Pisma.Pismo');

    public function view($id)
    {

        $this->set('output', $this->Pismo->getTemplate($id));
        $this->set('_serialize', 'output');

    }

}