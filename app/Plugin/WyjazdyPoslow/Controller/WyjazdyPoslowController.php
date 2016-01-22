<?php

App::uses('Sanitize', 'Utility');
App::uses('ApplicationsController', 'Controller');

class WyjazdyPoslowController extends ApplicationsController
{
    public $settings = array(
        'id' => 'wyjazdy_poslow',
        'title' => 'Wyjazdy posłów'
    );

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/wyjazdy_poslow/img/social/wyjazdy.jpg');
    }

    public function index()
    {

        $application = $this->getApplication();
        $stats = $this->WyjazdyPoslow->getStats();
        $this->set('stats', $stats);

        $this->set('title_for_layout', 'Wyjazdy zagraniczne posłow w VII Kadencji Sejmu');

    }
    
    public function getChapters()
    {
	    return array();
    }
}
