<?php

App::uses('Sanitize', 'Utility');

class RaportyGabinetyPolityczneController extends AppController
{
    public $name = 'GabinetyPolityczne';
    public $components = array();
    public $helpers = array();
    public $uses = array(
        'RaportyGabinetyPolityczne.GabinetyPolityczneOsoby',
        'RaportyGabinetyPolityczne.GabinetyPolityczneSrc',
        'RaportyGabinetyPolityczne.SPodmioty'
    );

    public function index()
    {
        $ministerstwa = array();
        $ministerstwa_bez_gabinetow = array();
        $this->SPodmioty->recursive = -1;

        $application = $this->getApplication();
        $this->set('title_for_layout', $application['Application']['name']);

        $osoby = $this->SPodmioty->find('all', array(
                'fields' => 'GabinetyPolityczneOsoby.*, SPodmioty.*, GabinetyPolityczneSrc.*',
                'conditions' => array('SPodmioty.aktualne' => '1', 'GabinetyPolityczneOsoby.aktualne' => '1'),
                'order' => array('SPodmioty.nazwa ASC'),
                'joins' => array(
                    array('table' => 'pl_gabinety_polityczne_osoby',
                        'alias' => 'GabinetyPolityczneOsoby',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'GabinetyPolityczneOsoby.s_podmioty_id = SPodmioty.id'
                        )
                    ),
                    array('table' => 'pl_gabinety_polityczne_src',
                        'alias' => 'GabinetyPolityczneSrc',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'GabinetyPolityczneSrc.s_podmioty_id = SPodmioty.id',
                        )
                    )
                )
            )
        );

        foreach ($osoby as $osoba) {
            if ($osoba['GabinetyPolityczneOsoby']['id'] == null) {
                array_push($ministerstwa_bez_gabinetow, str_replace('Minister', 'Ministerstwo', $osoba['SPodmioty']['nazwa']));

            } else {
                if (!isset($ministerstwa[$osoba['SPodmioty']['id']])) {
                    $ministerstwa[$osoba['SPodmioty']['id']] = array(
                        'name' => str_replace('Minister', 'Ministerstwo', $osoba['SPodmioty']['nazwa']),
                        'osoby' => array(),
                        'ministrant' => $osoba['SPodmioty']['aktualny_minister'],
                        'source_www' => $osoba['GabinetyPolityczneSrc']['source_www'],
                        'source_doc' => $osoba['GabinetyPolityczneSrc']['source_doc'],
                        'source_pdf_hand' => $osoba['GabinetyPolityczneSrc']['source_pdf_hand'],
                        'source_pdf_machine' => $osoba['GabinetyPolityczneSrc']['source_pdf_machine'],
                    );
                }

                array_push($ministerstwa[$osoba['SPodmioty']['id']]['osoby'], $osoba['GabinetyPolityczneOsoby']);
            }
        }

        $this->set(compact('ministerstwa', 'ministerstwa_bez_gabinetow'));
    }
}