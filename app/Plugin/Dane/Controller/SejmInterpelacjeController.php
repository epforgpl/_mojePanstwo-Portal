<?php

App::uses('DataobjectsController', 'Dane.Controller');
App::uses('Sanitize', 'Utility');

class SejmInterpelacjeController extends DataobjectsController
{
    public $menu = array();
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array(),
    );

    public function view($package = 1)
    {

        parent::view();

        if (
            isset($this->request->params['t_id']) &&
            $this->request->params['t_id']
        ) {

            $this->redirect($this->object->getUrl() . '/pismo/' . $this->request->params['t_id']);
            die();

        }

        $this->prepareFeed(array(
            'direction' => 'asc',
        ));

    }

    public function pismo()
    {

        parent::view();
        $pismo_id = @$this->request->params['pass'][0];

        if (
            $pismo_id &&
            ($pismo = $this->API->getObject('sejm_interpelacje_pisma', $pismo_id, array(
                'layers' => 'teksty',
            )))
        ) {

            $this->set('pismo', $pismo);

            if (empty($pismo->getLayers('teksty')) && $pismo->getData('dokument_id')) {

                $this->set('document', new MP\Document($pismo->getData('dokument_id')));
                $this->set('documentPackage', 1);

            }

        } else {

            $this->redirect($this->object->getUrl());
            die();

        }

    }

} 