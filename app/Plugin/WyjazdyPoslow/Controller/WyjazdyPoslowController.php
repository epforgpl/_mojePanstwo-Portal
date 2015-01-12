<?php

App::uses('Sanitize', 'Utility');

class WyjazdyPoslowController extends AppController
{
    public function index()
    {

        $application = $this->getApplication();

        $api = $this->API->WyjazdyPoslow();

        $stats = $api->getStats();
        $this->set('stats', $stats);

        $this->set('title_for_layout', 'Wyjazdy zagraniczne posłow w VII Kadencji Sejmu');

    }
}