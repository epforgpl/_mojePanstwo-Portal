<?php

class IndeksyController extends AppController
{

    public $components = array('RequestHandler');

    public function view()
    {

        $id = $this->request->params['id'];
        $api = mpapiComponent::getApi()->Kultura();

        $index = $api->getIndex($id);
        $this->set('index', $index);

    }
} 