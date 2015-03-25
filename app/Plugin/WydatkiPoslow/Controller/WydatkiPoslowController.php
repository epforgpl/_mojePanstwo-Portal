<?php

App::uses('Sanitize', 'Utility');

class WydatkiPoslowController extends AppController
{
    public function index()
    {

        $this->setMeta('image', '/wydatki_poslow/img/wydatki_poslow.png');
        $this->setMeta('description', 'Sprawdź na co posłowie wydają publiczne pieniądze.');

        $application = $this->getApplication();
        $stats = $this->WydatkiPoslow->getStats();
		
        $biura = array();
        foreach ($stats['biura'] as $d)
            $biura[$d['id']] = $d;
		
        $this->set('biura', $biura);
        $this->set('title_for_layout', 'Wydatki posłów');

    }
}