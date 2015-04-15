<?php

class GeoController extends AppController
{
    public $components = array(
        'RequestHandler',
    );
    public $uses = array();

    public function wojewodztwa()
    {
        $wojewodztwa = $this->Geo->wojewodztwa();
        $this->set(array(
            'wojewodztwa' => $wojewodztwa,
            '_serialize' => array('wojewodztwa'),
        ));
    }

    public function powiaty($wojewodztwo_id)
    {
        $powiaty = $this->Geo->powiaty($wojewodztwo_id);
        $this->set(array(
            'powiaty' => $powiaty,
            '_serialize' => array('powiaty'),
        ));
    }

    public function gminy($powiad_id)
    {
        $gminy = $this->Geo->gminy($powiad_id);
        $this->set(array(
            'gminy' => $gminy,
            '_serialize' => array('gminy'),
        ));
    }

    public function resolve($lat, $lng)
    {
        $resolve = $this->Geo->resolve($lat, $lng);
        $this->set(array(
            'resolve' => $resolve,
            '_serialize' => array('resolve'),
        ));
    }
} 