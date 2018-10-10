<?php
App::uses('DataobjectsController', 'Dane.Controller');

class ProcurementsController extends DataobjectsController
{	
	public function view($dataset, $id) {
		$this->redirect("https://rejestr.io/zamowienia_publiczne/" . $id);	
	}
} 