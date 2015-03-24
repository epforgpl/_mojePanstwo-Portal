<?php

App::uses('DataobjectsController', 'Dane.Controller');

class BdlWskaznikiKategorieController extends DataobjectsController
{

    public function view()
    {
        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'bdl_wskazniki_grupy',
	            'bdl_wskazniki_grupy.kategoria_id' => $this->object->getId(),
            )
        ));
        $this->set('DataBrowserTitle', 'Grupy wskaźników w tej kategorii');
        $this->render('DataBrowser/browser');
    }

} 