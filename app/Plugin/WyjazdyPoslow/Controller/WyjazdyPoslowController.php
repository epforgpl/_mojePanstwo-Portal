<?php

App::uses('Sanitize', 'Utility');

class WyjazdyPoslowController extends AppController
{
    public $settings = array(
        'id' => 'wyjazdy_poslow',
    );

    public function prepareMetaTags() {
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
}