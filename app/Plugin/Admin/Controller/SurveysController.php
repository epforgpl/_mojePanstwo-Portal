<?php

App::uses('AdminAppController', 'Admin.Controller');

/**
 * @property Survey Survey
 */
class SurveysController extends AdminAppController {

    public $uses = array('Admin.Survey');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'surveys');
    }

    public function index() {
        $this->set('surveys', $this->Survey->find('all'));
    }

    public function view($id = 0) {
        $id = (int) $id;
        if(!$id) throw new NotFoundException;

        $survey = $this->Survey->getSummary($id);
        if(!$survey) throw new NotFoundException;

        $this->set('survey',  $survey);
    }

}
