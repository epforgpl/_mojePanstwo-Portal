<?php

App::uses('DataobjectsController', 'Dane.Controller');

class ZamowieniaPubliczneWykonawcyController extends DataobjectsController
{

    public function view()
    {
		
		return $this->redirect('/zamowienia_publiczne/zamowienia?conditions[zamowienia_publiczne.wykonawca_id]=' . $this->request->params['id']);

        parent::view();

    }

} 