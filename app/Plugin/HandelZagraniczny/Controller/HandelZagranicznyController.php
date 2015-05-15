<?php

App::uses('Sanitize', 'Utility');

class HandelZagranicznyController extends AppController
{
    public $settings = array(
        'id' => 'handel_zagraniczny'
    );

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/handel_zagraniczny/img/social/handel.jpg');
    }

    public function index()
    {
        $this->setMeta('image', '/wydatki_poslow/img/wydatki_poslow.png');
        $this->setMeta('description', 'Sprawdź na co posłowie wydają publiczne pieniądze.');

        $application = $this->getApplication();

        $this->set('title_for_layout', 'Handel zagraniczny');
    }

}