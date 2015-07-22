<?php

App::uses('ApplicationsController', 'Controller');

class FinanseGminController extends ApplicationsController
{

    public $uses = array(
        'FinanseGmin.Finanse'
    );

    public $settings = array(
        'id' => 'finanse_gmin',
        'menu' => array(
            array(
                'id' => 'finanse_gmin',
                'label' => 'Finanse gmin'
            )
        ),
        'title' => 'Finanse Gmin',
        'subtitle' => 'Dane o finansach gmin Polsce',
        'headerImg' => 'bdl',
    );

    /*public function view()
    {
        $this->setMenuSelected();
        //$this->loadDatasetBrowser('bdl_wskazniki');
    }*/

    public function index()
    {
        $data = $this->Finanse->getBudgetData();
        $this->set('data', $data);
    }

    /**
     * Metody ze starego plugin`u Finanse
     *
     *     // poprzednia wersja działów
     * public function dzialy2()
     * {
     * $data = $this->API->Finanse()->getBudgetData();
     * $this->set('data', $data);
     *
     * // $application = $this->getApplication();
     * $this->set('title_for_layout', 'Wydatki gmin w Polsce');
     * }
     *
     * public function dzialy()
     * {
     * $data = $this->API->Finanse()->getBudgetData();
     * $this->set('data', $data);
     * $this->set('title_for_layout', 'Wydatki gmin w Polsce');
     * }
     *
     * public function getBudgetData()
     * {
     *
     * $data = $this->API->Finanse()->getBudgetData($this->request->query);
     * $this->set('data', $data);
     * $this->set('_serialize', 'data');
     *
     * }
     *
     * public function getBudgetData2()
     * {
     *
     * $data = $this->API->Finanse()->getBudgetData2($this->request->query);
     * $this->set('data', $data);
     * $this->set('_serialize', 'data');
     *
     * }
     */

} 