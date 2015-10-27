<?php

App::uses('StartAppController', 'Start.Controller');

class PagesController extends StartAppController {

    public $chapter_selected = 'pages';

    public function index() {

        $this->title = 'Moje Kolekcje';

        $options = array(
            'conditions' => array(
                'user-pages' => true,
            ),
        );

        $this->Components->load('Dane.DataBrowser', $options);

    }

}
