<?php

class MapaprawaController extends AppController
{
    public $settings = array(
        'id' => 'mapa_prawa'
    );

    public $components = array(
        'RequestHandler',
    );

    public function index()
    {
        $application = $this->getApplication();
        $this->set('title_for_layout', $application['Application']['name']);
    }

    public function view()
    {
        $application = $this->getApplication();
        $this->set('title_for_layout', $application['Application']['name']);

        $projekt_id = $this->request->params['projekt_id'];
        if ($projekt_id) {
            $projekt = $this->API->Dane()->getObject('legislacja_projekty_ustaw', $projekt_id);
            if ($projekt) {
                $this->set('projekt', $projekt);
                $this->set('path', $this->Mapaprawa->getPath($projekt));
            }
        }
    }

    public function loadBlockData()
    {

        $s = @$this->request->query['s'];
        $lang = @$this->request->query['lang'];

        list($dataset, $object_id) = explode('-', $s);

        $data = $this->API->MapaPrawa()->loadBlockData($dataset, $object_id);

        $this->set('data', $data);
        $this->set('_serialize', 'data');

    }

    public function loadItemData()
    {

        $s = @$this->request->query['s'];
        $blockId = (int)@$this->request->query['blockId'];
        $currentPage = (int)@$this->request->query['currentPage'];
        $limitPerPage = (int)@$this->request->query['limitPerPage'];
        $lang = @$this->request->query['lang'];

        list($dataset, $object_id) = explode('-', $s);

        $data = $this->API->MapaPrawa()->loadItemData($dataset, $object_id, $blockId, $currentPage, $limitPerPage, $lang);

        $this->set('data', $data);
        $this->set('_serialize', 'data');

    }

}