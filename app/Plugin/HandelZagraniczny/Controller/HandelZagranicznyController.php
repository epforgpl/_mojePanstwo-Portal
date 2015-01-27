<?php

App::uses('Sanitize', 'Utility');

class HandelZagranicznyController extends AppController
{
    public function index()
    {

        $this->setMeta('image', '/wydatki_poslow/img/wydatki_poslow.png');
        $this->setMeta('description', 'Sprawdź na co posłowie wydają publiczne pieniądze.');

        $application = $this->getApplication();
        $api = $this->API->HandelZagraniczny();

        /* $stats = $api->getCountriesData(array(
            'year'  => 2014
        )); */

        $this->set('title_for_layout', 'Handel zagraniczny');

    }
}