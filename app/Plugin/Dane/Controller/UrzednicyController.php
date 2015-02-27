<?php

App::uses('DataobjectsController', 'Dane.Controller');

class UrzednicyController extends DataobjectsController
{
    public $menu = array();
    public $initLayers = array();

    public function view()
    {
        parent::_prepareView();

        $this->dataobjectsBrowserView(array(
            // TODO conditions powiązanie z urzednikiem
            'conditions' => array(
            ),
            'dataset' => 'urzednicy_rejestr_korzysci',
            'title' => 'Oświadczenia majątkowe urzędnika',
            'noResultsTitle' => 'Brak oświadczeń',
            'excludeFilters' => array(
            ),
        ));
    }
} 