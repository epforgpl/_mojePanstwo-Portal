<?php

App::uses('Sanitize', 'Utility');

class RaportyDostepDoInformacjiPublicznejController extends AppController
{
    public function index()
    {
        $application = $this->getApplication();
        $this->set('title_for_layout', 'Dostęp do informacji publicznej');
        
    }
}