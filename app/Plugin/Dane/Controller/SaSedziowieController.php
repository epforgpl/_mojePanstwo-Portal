<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SaSedziowieController extends DataobjectsController
{

    public function view()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'sa_orzeczenia',
                'sa_orzeczenia.sedzia_id' => $this->object->getId(),
            )
        ));
        $this->set('DataBrowserTitle', 'Orzeczenia wydane przez sędziego');
        $this->render('DataBrowser/browser');


    }

} 