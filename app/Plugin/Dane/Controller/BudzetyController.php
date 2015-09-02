<?php

App::uses('DataobjectsController', 'Dane.Controller');

class BudzetyController extends DataobjectsController
{

    public $helpers = array('Document');

    // public $uses = array('Dane.Dataliner');

    public $observeOptions = true;

    public $headerObject = array('url' => '/dane/img/headers/ustawa.jpg', 'height' => '250px');

    public $objectOptions = array(
        'hlFields' => array(),
        'routes' => array(
            'description' => false,
        ),
    );

    public function _prepareView()
    {

        $aggs_fields = array();
        foreach (array('akty_uchylajace', 'akty_uchylone', 'akty_wykonawcze', 'akty_uznane_za_uchylone', 'akty_zmieniajace', 'akty_zmienione', 'informacja_o_tekscie_jednolitym', 'odeslania', 'orzeczenie_do_aktu', 'orzeczenie_tk', 'podstawa_prawna', 'tekst_jednolity_do_aktu', 'uchylenia_wynikajace_z') as $field) {
            $aggs_fields[$field] = array(
                'filter' => array(
                    'term' => array(
                        'data.prawo.' . $field => $this->request->params['id'],
                    ),
                ),
            );
        }

        $this->addInitAggs(array(
            'prawo' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'prawo',
                                ),
                            ),
                        ),
                    ),
                ),
                'scope' => 'global',
                'aggs' => $aggs_fields,
            ),
        ));

        return parent::_prepareView();

    }

    public function view()
    {

        $this->addInitLayers('wydatki');
        $this->addInitLayers('dzialy');
        $this->addInitAggs(array(
            'budzety' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'budzety',
                                ),
                            ),
                            array(
                                'range' => array(
                                    'data.budzety.rok' => array(
                                        'gte' => 1989
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'scope' => 'global',
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'size' => 100,
                            'sort' => array(
                                'date' => array(
                                    'order' => 'desc',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ));

        $this->_prepareView();
    }

    public function wydatki()
    {
        $types=array('czesci','dzialy');
        $type=$types[0];
        if(isset($this->request->param['type']) && in_array($this->request->param['type'], $types)){
            $type=$this->request->param['type'];
        }

        $this->addInitLayers($type);

        $this->_prepareView();

    }

    public function wydatki_dzialy()
    {

        $this->addInitLayers('dzialy');

        $this->_prepareView();

    }

    public function csv()
    {
        $this->addInitLayers('wydatki');
        $this->_prepareView();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Wydatki_budzetu_na_rok_' . $this->object->getData('rok') . '.csv');

        $output = fopen('php://output', 'w');

        fputcsv($output, array('Część', 'Dział', 'Rozdział', 'Treść', 'Poz.', 'Plan', 'Dotacje i subwencje', 'Świadczenia na rzecz osób fizycznych', 'Wydatki bieżace jednostek budżetowych', 'Wydatki majątkowe', 'Wydatki na obsługę długu', 'Środki własne UE', 'Współfinansowanie UE'));
        foreach ($this->object->getLayers('wydatki') as $row) {
            $out = array();
            $out[] = $row['pl_budzety_wydatki']['czesc_str'];
            $out[] = $row['pl_budzety_wydatki']['dzial_str'];
            $out[] = $row['pl_budzety_wydatki']['rozdzial_str'];
            $out[] = $row['pl_budzety_wydatki']['tresc'];
            $out[] = $row['pl_budzety_wydatki']['pozycja'];
            $out[] = $row['pl_budzety_wydatki']['plan'];
            $out[] = $row['pl_budzety_wydatki']['dotacje_i_subwencje'];
            $out[] = $row['pl_budzety_wydatki']['swiadczenia_na_rzecz_osob_fizycznych'];
            $out[] = $row['pl_budzety_wydatki']['wydatki_biezace_jednostek_budzetowych'];
            $out[] = $row['pl_budzety_wydatki']['wydatki_majatkowe'];
            $out[] = $row['pl_budzety_wydatki']['wydatki_na_obsluge_dlugu'];
            $out[] = $row['pl_budzety_wydatki']['srodki_wlasne_ue'];
            $out[] = $row['pl_budzety_wydatki']['wspolfinansowanie_ue'];
            fputcsv($output, $out);
        }
        $this->autoRender = false;
    }

    public function hasla()
    {
        $this->_prepareView();
    }

    public function tresc()
    {

        $this->_prepareView();

    }

    private function connections_view($id, $title)
    {

        $this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo',
                'prawo.' . $id => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', $title . ': ' . $this->object->getTitle());

    }

    public function podstawa_prawna()
    {
        return $this->connections_view('podstawa_prawna', 'Podstawa prawna');
    }

    public function podstawa_prawna_z_artykulem()
    {
        return $this->connections_view('podstawa_prawna_z_artykulem', 'Podstawa prawna z artykułem');
    }

    public function akty_zmienione()
    {
        return $this->connections_view('akty_zmienione', 'Akty zmienione');
    }

    public function akty_wykonawcze()
    {
        return $this->connections_view('akty_wykonawcze', 'Akty wykonawcze');
    }

    public function akty_uchylone()
    {
        return $this->connections_view('akty_uchylone', 'Akty uchylone');
    }

    public function akty_uznane_za_uchylone()
    {
        return $this->connections_view('akty_uznane_za_uchylone', 'Akty uznane za uchylone');
    }

    public function orzeczenie_do_aktu()
    {
        return $this->connections_view('orzeczenie_do_aktu', 'Orzeczenia do aktu');
    }

    public function tekst_jednolity_do_aktu()
    {
        return $this->connections_view('tekst_jednolity_do_aktu', 'Tekst jednolity do aktu');
    }

    public function orzeczenia_tk()
    {
        return $this->connections_view('orzeczenie_tk', 'Orzeczenia TK');
    }

    public function informacja_o_tekscie_jednolitym()
    {
        return $this->connections_view('informacja_o_tekscie_jednolitym', 'Informacje o tekście jednolitym');
    }

    public function akty_zmieniajace()
    {
        return $this->connections_view('akty_zmieniajace', 'Nowelizacje');
    }

    public function akty_uchylajace()
    {
        return $this->connections_view('akty_uchylajace', 'Akty uchylające');
    }

    public function uchylenia_wynikajace_z()
    {
        return $this->connections_view('uchylenia_wynikajace_z', 'Uchylenia wynikające z');
    }

    public function dyrektywy_europejskie()
    {
        return $this->connections_view('dyrektywy_europejskie', 'Dyrektywy europejskie');
    }

    public function odeslania()
    {
        return $this->connections_view('odeslania', 'Odesłania');
    }

    public function getMenu()
    {

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Start',
                ),

            ),
            'base' => $this->object->getUrl(),
        );

        if (count(@$this->object->getLayers('wydatki')) !== 0) {
            $menu['items'][] = array(
                'id' => 'wydatki',
                'label' => 'Wydatki'
            );
        }

        if (@$this->object_aggs['prawo']['akty_uchylajace']['doc_count'])
            $menu['items'][] = array(
                'id' => 'akty_uchylajace',
                'label' => 'Akty uchylające',
                'count' => $this->object_aggs['prawo']['akty_uchylajace']['doc_count'],
            );


        $menu['items'][] = array(
            'id' => 'tresc',
            'label' => 'Treść ustawy',
        );

        if (@$this->object_aggs['prawo']['akty_uchylajace']['doc_count'])
            $menu['items'][] = array(
                'id' => 'akty_uchylajace',
                'label' => 'Akty uchylające',
                'count' => $this->object_aggs['prawo']['akty_uchylajace']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['akty_uchylone']['doc_count'])
            $menu['items'][] = array(
                'id' => 'akty_uchylone',
                'label' => 'Akty uchylone',
                'count' => $this->object_aggs['prawo']['akty_uchylone']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['akty_wykonawcze']['doc_count'])
            $menu['items'][] = array(
                'id' => 'akty_wykonawcze',
                'label' => 'Akty wykonawcze',
                'count' => $this->object_aggs['prawo']['akty_wykonawcze']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['akty_uznane_za_uchylone']['doc_count'])
            $menu['items'][] = array(
                'id' => 'akty_uznane_za_uchylone',
                'label' => 'Akty uznane za uchylone',
                'count' => $this->object_aggs['prawo']['akty_uznane_za_uchylone']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['akty_zmieniajace']['doc_count'])
            $menu['items'][] = array(
                'id' => 'akty_zmieniajace',
                'label' => 'Nowelizacje',
                'count' => $this->object_aggs['prawo']['akty_zmieniajace']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['akty_zmienione']['doc_count'])
            $menu['items'][] = array(
                'id' => 'akty_zmienione',
                'label' => 'Akty zmienione',
                'count' => $this->object_aggs['prawo']['akty_zmienione']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['informacja_o_tekscie_jednolitym']['doc_count'])
            $menu['items'][] = array(
                'id' => 'informacja_o_tekscie_jednolitym',
                'label' => 'Informacja o tekście jednolitym',
                'count' => $this->object_aggs['prawo']['informacja_o_tekscie_jednolitym']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['odeslania']['doc_count'])
            $menu['items'][] = array(
                'id' => 'odeslania',
                'label' => 'Odesłania',
                'count' => $this->object_aggs['prawo']['odeslania']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['orzeczenie_do_aktu']['doc_count'])
            $menu['items'][] = array(
                'id' => 'orzeczenie_do_aktu',
                'label' => 'Orzeczenia do aktu',
                'count' => $this->object_aggs['prawo']['orzeczenie_do_aktu']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['orzeczenie_tk']['doc_count'])
            $menu['items'][] = array(
                'id' => 'orzeczenia_tk',
                'label' => 'Orzeczenia TK',
                'count' => $this->object_aggs['prawo']['orzeczenie_tk']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['podstawa_prawna']['doc_count'])
            $menu['items'][] = array(
                'id' => 'podstawa_prawna',
                'label' => 'Podstawa prawna',
                'count' => $this->object_aggs['prawo']['podstawa_prawna']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['tekst_jednolity_do_aktu']['doc_count'])
            $menu['items'][] = array(
                'id' => 'tekst_jednolity_do_aktu',
                'label' => 'Tekst jednolity do aktu',
                'count' => $this->object_aggs['prawo']['tekst_jednolity_do_aktu']['doc_count'],
            );

        if (@$this->object_aggs['prawo']['uchylenia_wynikajace_z']['doc_count'])
            $menu['items'][] = array(
                'id' => 'uchylenia_wynikajace_z',
                'label' => 'Uchylenia wynikające z',
                'count' => $this->object_aggs['prawo']['uchylenia_wynikajace_z']['doc_count'],
            );

        return $menu;
    }

}
