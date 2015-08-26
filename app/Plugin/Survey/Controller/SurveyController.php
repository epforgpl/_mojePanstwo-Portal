<?php

App::uses('AppController', 'Controller');

/**
 * @property Survey Survey
 */
class SurveyController extends AppController {

    public $components = array('RequestHandler');
    public $uses = array('Survey.Survey');

    public function save() {
        $this->set('response', $this->Survey->save($this->request->data));
        $this->set('_serialize', array('response'));
    }

}
