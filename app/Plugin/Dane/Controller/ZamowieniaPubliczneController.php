<?php

App::uses('DataobjectsController', 'Dane.Controller');

class ZamowieniaPubliczneController extends DataobjectsController
{
    public $menu = array();
    public $objectOptions = array(
        'hlFields' => array('status_id', 'rodzaj_id'),
    );

    public $loadChannels = true;
    public $addDatasetBreadcrumb = false;

    // public $initLayers = array('details', 'sources', 'czesci');
    public $initLayers = array('channels', 'details', 'sources');

    public function view()
    {

        $this->load();
        $this->loadDoc($this->request->params['id']);

    }

    public function load()
    {

        $this->addInitAggs(array(
            'dokumenty' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne_dokumenty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne_dokumenty.parent_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'scope' => 'global',
                'aggs' => array(
                    'wykonawcy' => array(
                        'nested' => array(
                            'path' => 'zamowienia_publiczne-wykonawcy',
                        ),
                        'aggs' => array(
                            'top' => array(
                                'terms' => array(
                                    'field' => 'zamowienia_publiczne-wykonawcy.id',
                                ),
                                'aggs' => array(
                                    'nazwa' => array(
                                        'terms' => array(
                                            'field' => 'zamowienia_publiczne-wykonawcy.nazwa',
                                        ),
                                    ),
                                    'krs_id' => array(
                                        'terms' => array(
                                            'field' => 'zamowienia_publiczne-wykonawcy.krs_id',
                                        ),
                                    ),
                                    'waluta' => array(
                                        'terms' => array(
                                            'field' => 'zamowienia_publiczne-wykonawcy.waluta',
                                        ),
                                    ),
                                    'cena' => array(
                                        'sum' => array(
                                            'field' => 'zamowienia_publiczne-wykonawcy.cena',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ));

        parent::load();
    }

    public function loadDoc($id = false)
    {
        if (
            $id &&
            ($dokument = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'zamowienia_publiczne_dokumenty',
                    'id' => $id,
                ),
                'layers' => array(
                    'details'
                ),
            )))
        ) {

            $_details = $dokument->getLayer('details');
            $details = array();
            $text_details = array();


            if (!empty($_details)) {

                // 'siwz_www', 'siwz_adres', 'oferty_miejsce'

                $text_details_keys = array(
                    'uprawnienie',
                    'wiedza',
                    'potencjal',
                    'osoby_zdolne',
                    'sytuacja_ekonomiczna',
                    'zal_pprawna',
                    'zal_uzasadnienie',
                    'zamowienie_uzupelniajace',
                    'wadium',
                    'wybor_wykonawcow',
                    'zmieniona_umowa',
                    'aukcja_www',
                    'dk_potrzeby',
                    'dk_nagrody',
                    'umowa_zabezpieczenia',
                    'umowa_istotne_postanowienia',
                    'info',
                    'inne_dokumenty',
                    'inne_dok_potw',
                    'zal_pprawna_hid',
                    'zamowienie_pprawna',
                    'zamowienie_pprawna_hid',
                    'zamowienie_uzasadnienie',
                    'le_wymagania',
                    'le_postapien'
                );


                foreach ($_details as $key => $value) {

                    if (!$value) {
                        continue;
                    }

                    if (in_array($key, $text_details_keys)) {
                        $text_details[$key] = $value;
                    } else {
                        $details[$key] = $value;
                    }

                }


                if (
                    isset($details['siwz_www']) &&
                    ($details['siwz_www'] = str_ireplace('nie dotyczy', '', $details['siwz_www'])) &&
                    (stripos($details['siwz_www'], 'http') !== 0)
                ) {
                    $details['siwz_www'] = 'http://' . $details['siwz_www'];
                }

            }

            $feed = $this->feed(array(
                'direction' => 'asc',
                'timeline' => true,
                'mode' => 'min',
            ));

            $this->set('dokument', $dokument);
            $this->set('details', $details);
            $this->set('text_details', $text_details);

            if($this->hasUserRole('2')){
                $this->set('admin', true);
            }

        }

    }

    public function dokumenty()
    {

        $this->load();

        if (isset($this->request->params['subid']))
            $this->loadDoc($this->request->params['subid']);

        $this->view = 'view';

    }

} 