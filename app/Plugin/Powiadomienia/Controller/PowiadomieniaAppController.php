<?php

class PowiadomieniaAppController extends AppController
{
    public $helpers = array(
        'Dane.Dataobject',
    );
    public $pagination = array();

    public function beforeFilter()
    {

        if (
            ($this->request->params['controller'] == 'powiadomienia') &&
            ($this->request->params['action'] == 'index')
        ) {

            $this->API = $this->API->Powiadomienia();
            parent::beforeFilter();

        } else {

            if ($this->Auth->loggedIn()) {

                $this->API = $this->API->Powiadomienia();
                parent::beforeFilter();

            } else {

                $this->API = $this->API->Powiadomienia();
                parent::beforeFilter();
                // throw new ForbiddenException('Please login');

            }

        }

        $appMenu = array(
            array('id' => '', 'label' => 'Moje powiadomienia'),
            array('id' => 'obserwuje', 'label' => 'Obserwuję'),
            array('id' => 'jak_to_dziala', 'label' => 'Jak to działa?')
        );

        $this->set('appMenu', $appMenu);
    }

}