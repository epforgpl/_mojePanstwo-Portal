<?php

App::uses('Sanitize', 'Utility');

class RaportyDostepDoInformacjiPublicznejController extends AppController
{
    public $settings = array(
        'id' => 'dostep_do_informacji_publicznej'
    );

    public function index()
    {
        $application = $this->getApplication();
        $this->set('title_for_layout', 'Dostęp do informacji publicznej');
        
    }
}