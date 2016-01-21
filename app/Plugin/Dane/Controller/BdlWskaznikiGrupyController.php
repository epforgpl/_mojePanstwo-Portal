<?php

App::uses('DataobjectsController', 'Dane.Controller');

class BdlWskaznikiGrupyController extends DataobjectsController
{

    public function view()
    {
        parent::load();
        return $this->redirect('/bdl#' . $this->object->getData('bdl_wskazniki_kategorie.slug'));
                
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'bdl_wskazniki',
                'bdl_wskazniki.grupa_id' => $this->object->getId(),
            )
        ));
        $this->set('DataBrowserTitle', 'Wskaźniki w tej grupie');
        $this->render('DataBrowser/browser');
    }

} 