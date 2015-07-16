<?php

App::uses('ApplicationsController', 'Controller');

class BdlTempItemsController extends ApplicationsController
{

    public $components = array('RequestHandler');

    public $settings = array(
        'id' => 'bdl',
        'title' => 'Bdl',
        'subtitle' => 'Dane statystyczne o Polsce',
    );

    public function index()
    {

        $this->setLayout(array(
            'footer' => array(
                'element' => 'minimal',
            ),
            'header' => array(
                'element' => 'empty',
                //TODO:po przejsciu na baze "dataobject-bdl"
            ),
        ));

        $BdlTempItems = $this->BdlTempItem->searchAll();
        $this->set(array(
            'BdlTempItems' => $BdlTempItems,
            '_serialize' => array('BdlTempItems')
        ));

        $datasets = $this->getDatasets('bdl');
        $options = array(
            'searchTitle' => 'Szukaj w Banku Danych Lokalnych...',
            'autocompletion' => array(
                'dataset' => 'bdl_wskazniki',
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Bdl',
                    'element' => 'cover',
                ),
                'aggs' => array(),
            ),
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'label' => 'Zbiory danych',
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                    ),
                ),
            ),
        );

        if (!isset($this->request->query['q']) || empty($this->request->query['q'])) {

            $tree = Cache::read('BDL.tree', 'long');
            if (!$tree) {
                $this->loadModel('Bdl.BDL');
                $tree = $this->BDL->getTree();
                Cache::write('BDL.tree', $tree, 'long');
            }

            $this->set('tree', $tree);

        }

        $this->Components->load('Dane.DataBrowser', $options);
    }

    public function view($id, $type='BDL')
    {
        $this->setLayout(array(
            'footer' => array(
                'element' => 'minimal',
            ),
            'header' => array(
                'element' => 'empty',
                //TODO:po przejsciu na baze "dataobject-bdl"
            ),
        ));

        $BdlTempItems = $this->BdlTempItem->searchAll();

        $BdlTempItem = $this->BdlTempItem->searchById($id, $type);

        $this->set(array(
            'BdlTempItem' => $BdlTempItem,
            'BdlTempItems' => $BdlTempItems,
            '_serialize' => array('BdlTempItem'),
            'id' => $id
        ));

        if ($BdlTempItem == false) {
            $this->redirect(array('action' => 'index'));
        }

        $datasets = $this->getDatasets('bdl');
        $options = array(
            'searchTitle' => 'Szukaj w Banku Danych Lokalnych...',
            'autocompletion' => array(
                'dataset' => 'bdl_wskazniki',
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Bdl',
                    'element' => 'cover',
                ),
                'aggs' => array(),
            ),
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'label' => 'Zbiory danych',
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                    ),
                ),
            ),
        );

        if (!isset($this->request->query['q']) || empty($this->request->query['q'])) {

            $tree = Cache::read('BDL.tree', 'long');
            if (!$tree) {
                $this->loadModel('Bdl.BDL');
                $tree = $this->BDL->getTree();
                Cache::write('BDL.tree', $tree, 'long');
            }
            $this->set('tree', $tree);
        }

        $this->Components->load('Dane.DataBrowser', $options);
    }

    public function add()
    {
        $this->BdlTempItem->create();
        if ($this->BdlTempItem->save($this->request->data, $this->request->data['type'])) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));

        $this->redirect($this->referer());
    }

    public function edit($id)
    {
        $this->BdlTempItem->id = $id;
        if ($this->BdlTempItem->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));

        $this->redirect($this->referer());
    }

    public function delete($id)
    {
        if ($this->BdlTempItem->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));

        $this->redirect($this->referer());
    }

    public function listall()
    {
        $this->autoRender = false;
        $data = $this->BdlTempItem->searchList();
                
        // Tu musi zwracac stringa

        $this->json($data);
    }

    public function getone()
    {
        $src = $this->request->data;
        $this->autoRender = false;
        $data = $this->BdlTempItem->searchById($src['id']);

        $this->json($data);
    }

    public function addIngredients($item_id = false)
    {
        $data = $this->request->data;
        $old = $this->BdlTempItem->searchById($data['id']);

        $data = array_merge($old, $data);

        if ($this->BdlTempItem->save($data)) {
            $this->json(true);
        } else {
            $this->json(false);
        }

        $this->autoRender = false;
    }


}