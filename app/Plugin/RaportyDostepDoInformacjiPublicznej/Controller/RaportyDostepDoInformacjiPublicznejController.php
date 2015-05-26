<?php

App::uses('Sanitize', 'Utility');

class RaportyDostepDoInformacjiPublicznejController extends AppController
{
    public $settings = array(
        'id' => 'dostep_do_informacji_publicznej',
        'title' => 'Dostęp do informacji publicznej',
    );

    public function index()
    {
        $this->setLayout(array('header' => false, 'footer' => array('element' => 'minimal')));
        $this->set('title_for_layout', 'Dostęp do informacji publicznej');
    }
}