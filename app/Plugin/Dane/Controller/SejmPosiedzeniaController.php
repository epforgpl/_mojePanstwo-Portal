<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmPosiedzeniaController extends DataobjectsController
{
    public $menu = array();
    public $autoRelated = false;
    public $helpers = array(
        'Number',
    );
    public $uses = array(
        'Dane.Dataobject',
    );
    public $objectOptions = array(
        'bigTitle' => true,
    );

    public $breadcrumbsMode = 'app';

    public $hlmap = array(
        array(
            'id' => 'liczba_wystapien',
            'label' => 'Wystąpienia',
            'href' => 'wystapienia',
        ),
        array(
            'id' => 'liczba_glosowan',
            'label' => 'Głosowania',
            'href' => 'glosowania',
        ),
        array(
            'id' => 'liczba_punktow',
            'label' => 'Punkty porządku dziennego',
            'href' => 'punkty',
        ),
        array(
            'id' => 'liczba_przyjetych_ustaw',
            'label' => 'Przyjęte ustawy',
            'href' => 'projekty#przyjete_ustawy',
        ),
        array(
            'id' => 'liczba_odrzuconych_ustaw',
            'label' => 'Odrzucone ustawy',
            'href' => 'projekty#odrzucone_ustawy',
        ),
        array(
            'id' => 'liczba_przyjetych_uchwal',
            'label' => 'Przyjęte uchwały',
            'href' => 'projekty#przyjete_uchwaly',
        ),
        array(
            'id' => 'liczba_odrzuconych_uchwal',
            'label' => 'Odrzucone uchwały',
            'href' => 'projekty#odrzucone_uchwaly',
        ),
        /*
        array(
            'id' => 'liczba_ratyfikowanych_umow',
            'label' => 'Ratyfikowane umowy międzynarodowe',
            'href' => 'projekty#ratyfikowane_umowy',
        ),
        array(
            'id' => 'liczba_odrzuconych_umow',
            'label' => 'Odrzucone umowy międzynarodowe',
            'href' => 'projekty#odrzucone_umowy',
        ),
        array(
            'id' => 'liczba_przyjetych_sprawozdan_kontrolnych',
            'label' => 'Przyjęte sprawozdania kontrolne',
            'href' => 'projekty#przyjete_sprawozdania_kontrolne',
        ),
        array(
            'id' => 'liczba_odrzuconych_sprawozdan_kontrolnych',
            'label' => 'Odrzucone sprawozdania kontrolne',
            'href' => 'projekty#odrzucone_sprawozdania_kontrolne',
        ),
        array(
            'id' => 'liczba_przyjetych_referendow',
            'label' => 'Przyjęte wnioski o referenda',
            'href' => 'projekty#przyjete_referenda',
        ),
        array(
            'id' => 'liczba_odrzuconych_referendow',
            'label' => 'Odrzucone wnioski o referenda',
            'href' => 'projekty#odrzucone_referenda',
        ),
        array(
            'id' => 'liczba_przyjetych_powolan_odwolan',
            'label' => 'Przyjęte powołania / odwołania',
            'href' => 'projekty#przyjete_powolania_odwolania',
        ),
        array(
            'id' => 'liczba_odrzuconych_powolan_odwolan',
            'label' => 'Odrzucone powołania / odwołania',
            'href' => 'projekty#odrzucone_powolania_odwolania',
        ),
        array(
            'id' => 'liczba_przyjetych_zmian_komisji',
            'label' => 'Przyjęte zmiany w składach komisji',
            'href' => 'projekty#przyjete_zmiany_komisji',
        ),
        array(
            'id' => 'liczba_odrzuconych_zmian_komisji',
            'label' => 'Odrzucone zmiany w składach komisji',
            'href' => 'projekty#odrzucone_zmiany_komisji',
        ),
        array(
            'id' => 'liczba_przyjetych_inne',
            'label' => 'Przyjęte inne dokumenty',
            'href' => 'projekty#przyjete_inne',
        ),
        array(
            'id' => 'liczba_odrzuconych_inne',
            'label' => 'Odrzucone inne dokumenty',
            'href' => 'projekty#odrzucone_inne',
        ),
        */
    );


    public function getMenu()
    {

        // PREPARE MENU

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Rozpatrywane projekty',
                ),
                array(
                    'id' => 'punkty',
                    'label' => 'Punkty porządku dziennego',
                ),
                array(
                    'id' => 'wystapienia',
                    'label' => 'Wystąpienia',
                ),
                array(
                    'id' => 'glosowania',
                    'label' => 'Głosowania',
                ),
            ),
            'base' => $this->object->getUrl(),
        );

        return $menu;

    }


    public function view()
    {

        parent::view();
        return $this->redirect($this->object->getUrl());

    }

    public function punkty()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'sejm_posiedzenia_punkty',
                'sejm_posiedzenia_punkty.posiedzenie_id' => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', "Punkty porządku dziennego | " . $this->object->getTitle());

    }

    public function wystapienia()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'sejm_wystapienia',
                'sejm_wystapienia.posiedzenie_id' => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', "Wystąpienia | " . $this->object->getTitle());

    }

    public function glosowania()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'sejm_glosowania',
                'sejm_glosowania.posiedzenie_id' => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', "Głosowania | " . $this->object->getTitle());

    }

} 