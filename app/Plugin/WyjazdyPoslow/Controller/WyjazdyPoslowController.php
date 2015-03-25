<?php

App::uses('Sanitize', 'Utility');

class WyjazdyPoslowController extends AppController
{
    public function index()
    {

        $application = $this->getApplication();
        $stats = $this->WyjazdyPoslow->getStats();
        $this->set('stats', $stats);

        $this->set('title_for_layout', 'Wyjazdy zagraniczne posłow w VII Kadencji Sejmu');

    }
}