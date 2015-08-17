<?php

App::uses('AppController', 'Controller');

class GminyController extends AppController {

    public $uses = array(
        'Finanse.GminaBudzet'
    );

    public $components = array('RequestHandler');

    public function dzialy($gmina_id, $typ) {
        $this->set(array(
            'dzialy' => $this->GminaBudzet->getDzialy($gmina_id, $typ),
            '_serialize' => array('dzialy'),
        ));
    }

    public function dzial($id, $gmina_id, $typ) {
        $this->set(array(
            'dzial' => $this->GminaBudzet->getDzial($id, $gmina_id, $typ),
            '_serialize' => array('dzial'),
        ));
    }

}
