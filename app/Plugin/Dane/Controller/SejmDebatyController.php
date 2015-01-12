<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SejmDebatyController extends DataobjectsController
{

    public $uses = array('Dane.Dataobject');
    public $breadcrumbsMode = 'app';
    public $objectOptions = array(
        'hlFields' => array(),
    );


    public function view()
    {

        $this->addInitLayers(array('nav'));
        parent::view();


        if (
            ($nav = $this->object->getLayer('nav')) &&
            isset($nav['posiedzenie']) &&
            isset($nav['posiedzenie']['punkty']) &&
            !empty($nav['posiedzenie']['punkty'])
        ) {

            $this->redirect('/dane/sejm_posiedzenia_punkty/' . $nav['posiedzenie']['punkty'][0]['id'] . '/debaty/' . $this->object->getId());

        } else {


            $this->dataobjectsBrowserView(array(
                'source' => 'sejm_debaty.wystapienia:' . $this->object->getId(),
                'dataset' => 'sejm_wystapienia',
                'noResultsTitle' => 'Brak wystąpień',
                'order' => '_ord asc',
                'renderFile' => 'sejm_debaty-wystapienie',
                'limit' => 100,
                'class' => 'debata-wystapienia',
            ));


        }
    }

    public function wystapienia()
    {

        $this->_prepareView();

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $wystapienie = $this->API->getObject('sejm_wystapienia', $this->request->params['pass'][0], array(
                'layers' => 'html',
            ));
            $this->set('wystapienie', $wystapienie);
            $this->render('wystapienie');


        } else {

            $this->redirect($this->object->getUrl());
            die();

        }

    }

    public function glosowania()
    {

        $this->_prepareView();
        $this->request->params['action'] = 'glosowania';

        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $glosowanie = $this->API->getObject('sejm_glosowania', $this->request->params['pass'][0], array('layers' => 'wynikiKlubowe'));
            $this->set('glosowanie', $glosowanie);

            $this->dataobjectsBrowserView(array(
                'source' => 'sejm_glosowania.glosy:' . $glosowanie->getId(),
                'dataset' => 'poslowie_glosy',
                'noResultsTitle' => 'Brak wyników',
                'title' => 'Wyniki indywidualne',
                'order' => '_title asc',
                'renderFile' => 'glosowania-glosy',
                'class' => 'glosowania-glosy',
                'limit' => 100,
                'excludeFilters' => array(
                    'sejm_glosowania.typ_id'
                ),
            ));

            $this->render('glosowanie');

        } else {

            $this->dataobjectsBrowserView(array(
                'source' => 'sejm_debaty.glosowania:' . $this->object->getId(),
                'dataset' => 'sejm_glosowania',
                'noResultsTitle' => 'Brak głosowań',
                'order' => 'numer asc',
                'renderFile' => 'sejm_debaty-glosowanie',
                'class' => 'debata-glosowania',
                'limit' => 100
            ));

        }

    }

} 