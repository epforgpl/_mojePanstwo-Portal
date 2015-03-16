<?php

class PrawoController extends AppController
{
    public $components = array(
        'Session',
        'RequestHandler'
    );
    public $helpers = array('Dane.Dataobject');
    public $uses = array('Dane.Dataliner');

    public function beforeRender()
    {
        $appMenu = array(
            array('id' => '', 'label' => 'Start'),
            array('id' => 'akty', 'label' => 'Akty prawne'),
            array('id' => 'tematy', 'label' => 'Tematy')
        );

        $this->set('appMenu', $appMenu);
    }

    public function start()
    {
        $data = $this->API->Prawo()->getData();

        $this->set('keywords', $data['keywords']);
        $this->set('popular', $data['popular']);
        $this->set('types', $data['types']);

        $API = $this->API->Dane();
        $data = $API->searchDataset('prawo', array(
            'order' => 'data_wejscia_w_zycie desc',
            'limit' => 5,
            'conditions' => array(
                'data_wejscia_w_zycie' => '[* TO NOW]',
                'typ_id' => '1',
            ),
        ));
        $this->set('ustawy_przeszlosc', $API->getObjects());

        $data = $API->searchDataset('prawo', array(
            'order' => 'data_wejscia_w_zycie asc',
            'limit' => 5,
            'conditions' => array(
                'data_wejscia_w_zycie' => '[NOW TO *]',
                'typ_id' => '1',
            ),
        ));
        $this->set('ustawy_przyszlosc', $API->getObjects());

        $data = $API->searchDataset('prawo_projekty', array(
            'order' => '_date desc',
            'limit' => 5,
            'conditions' => array(
                'typ_id' => '1',
            ),
        ));
        $this->set('projekty', $API->getObjects());
        $this->set('appMenuSelected', '');
    }

    public function akty()
    {
        $this->set('appMenuSelected', 'akty');
        
        /*
        $this->dataBrowser = $this->Components->load('Dane.DataobjectsBrowser', array(
            'source' => 'dataset:prawo',
            'showTitle' => true,
            'titleTag' => 'h1',
        ));
        $this->API = $this->API->Dane();
        */
        
    }

    public function tematy()
    {
        $this->set('appMenuSelected', 'tematy');
    }

    public function weszly()
    {

        $filter_field = 'typ_id';
        $default_filters = array('1');

        $filters = $this->API->Prawo()->getTypes();
        foreach ($filters as &$filter) {
            if (in_array($filter['id'], $default_filters)) {
                $filter['selected'] = true;
            }
        }


        $datalinerParams = array(
            'requestData' => array(
                'conditions' => array(
                    '_source' => 'prawo.weszly',
                    'dataset' => 'prawo',
                ),
                'order' => 'data_wejscia_w_zycie desc',
            ),
        );

        $data = $this->Dataliner->index(array(
            'conditions' => array_merge($datalinerParams['requestData']['conditions'], array(
                $filter_field => $default_filters,
            )),
            'order' => 'data_wejscia_w_zycie desc',
        ));

        $datalinerParams['initData'] = $data;
        $datalinerParams['filters'] = $filters;
        $datalinerParams['filterField'] = $filter_field;

        $this->set('datalinerParams', $datalinerParams);


        /*
        // NIEDAWNO WESZŁY

        $api->searchDataset('ustawy', array(
            'conditions' => array(
                'prawo.data_wejscia_w_zycie' => '[* TO NOW/DAY]',
            ),
            'limit' => 5,
            'order' => 'prawo.data_wejscia_w_zycie desc',
        ));
        $data['niedawno_weszly'] = $api->getObjects();


        // NIEDŁUGO WEJDĄ

        $api->searchDataset('ustawy', array(
            'conditions' => array(
                'prawo.data_wejscia_w_zycie' => '[NOW/DAY TO *]',
            ),
            'limit' => 5,
            'order' => 'prawo.data_wejscia_w_zycie asc',
        ));
        $data['niedlugo_wejda'] = $api->getObjects();


        // KODEKSY

        $api->searchDataset('ustawy', array(
            'conditions' => array(
                'status_id' => '1',
                'typ_id' => '3',
            ),
            'limit' => 15,
            'order' => 'tytul_skrocony asc',
        ));
        $data['kodeksy'] = $api->getObjects();


        // KONSTYTUCJE

        $api->searchDataset('ustawy', array(
            'conditions' => array(
                'status_id' => '1',
                'typ_id' => '2',
            ),
            'limit' => 15,
            'order' => 'tytul_skrocony asc',
        ));
        $data['konstytucje'] = $api->getObjects();

        $this->set('data', $data);
        */


    }

    public function wejda()
    {


    }

    public function slowa_kluczowe()
    {


    }

    public function search()
    {
        if (isset($this->request->params['ext']) && ($this->request->params['ext'] == 'json')) {

            $api = $this->API->Dane();
            $search = array();

            $q = @$this->request->query['q'];
            if ($q) {
                $api->searchDataset('ustawy', array(
                    'conditions' => array(
                        'q' => $q,
                        'status_id' => '1',
                    ),
                    'limit' => 10,
                ));
                $objects = $api->getObjects();

                foreach ($objects as $obj) {
                    $search[] = array_merge($obj->getData(), array(
                        'data_slowna' => dataSlownie($obj->getData('prawo.data_publikacji')),
                        'hl' => $obj->getHlText(),
                    ));
                }
            }

            $this->set('search', $search);
            $this->set('_serialize', array('search'));

        } else {
            $this->redirect('/ustawy');
        }
    }

} 