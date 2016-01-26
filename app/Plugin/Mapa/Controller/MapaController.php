<?php

App::uses('ApplicationsController', 'Controller');

class MapaController extends ApplicationsController
{
    public $components = array('RequestHandler');

    public $settings = array(
        'id' => 'mapa',
        'title' => 'Mapa'
    );

    public $submenus = array(
        'mapa' => array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Start',
                )
            )
        )
    );

    public function obwody()
    {

        $data = $this->Mapa->obwody($this->request->query['id']);

        $this->set('data', $data);
        $this->set('_serialize', 'data');

    }

    public function view()
    {

        $this->title = 'Mapa';

        $options = array(
            'searchTag' => array(
                'href' => '/mapa',
                'label' => 'Mapa',
            ),
            'conditions' => array(
                'dataset' => array('miejsca'),
                'miejsca.ignore' => false,
            ),
            'apps' => true,
            'limit' => 10,
            'apps' => true,
        );

        $layers = '';
		if( isset( $this->request->params['layers'] ) )
			$layers = $this->request->params['layers'];

        $this->set('layers', $layers);
        $this->Components->load('Dane.DataBrowser', $options);
    }

    public function getChapters() {

		$mode = false;
		$items = array(
			array(
				'id' => 'adm',
				'label' => 'Podział administracyjny',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			array(
				'id' => 'wojewodztwa',
				'href' => '/mapa/wojewodztwa',
				'label' => 'Województwa',
				'icon' => 'icon-datasets-dot',
			),
			array(
				'id' => 'powiaty',
				'href' => '/mapa/powiaty',
				'label' => 'Powiaty',
				'icon' => 'icon-datasets-dot',
			),
			array(
				'id' => 'gminy',
				'href' => '/mapa/gminy',
				'label' => 'Gminy',
				'icon' => 'icon-datasets-dot',
			),
			array(
				'id' => 'krs',
				'href' => '/mapa/krs',
				'label' => 'Organizacje',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			array(
				'id' => 'ngo',
				'href' => '/mapa/ngo',
				'label' => 'NGO',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			array(
				'id' => 'instytucje',
				'href' => '/mapa/instytucje',
				'label' => 'Instytucje publiczne',
				'icon' => 'icon-datasets-krs_podmioty',
			),
			array(
				'id' => 'wybory',
				'href' => '/mapa/wybory',
				'label' => 'Komisje wyborcze',
				'icon' => 'icon-datasets-krs_podmioty',
			),
		);

        $output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}

    public function layer()
    {

        if (
            isset($this->request->query['tl']) &&
            isset($this->request->query['br']) &&
            @$this->request->query['layer']
        ) {

            $tl = $this->request->query['tl'];
			$br = $this->request->query['br'];

            $strlen = strlen($tl);

            if ($strlen == 10)
                $strlen = 9;

            if ($strlen == 12)
                $strlen = 11;

            if ($strlen == 14)
                $strlen = 13;

            if ($strlen == 16)
                $strlen = 15;


            $must = array(
                array(
                    'geo_bounding_box' => array(
                        'position' => array(
                            'top_left' => $tl,
                            'bottom_right' => $br,
                        ),
                    ),
                ),
            );

            if ($this->request->query['layer'] == 'biznes') {

                $must[] = array(
                    'term' => array(
                        'dataset' => 'krs_podmioty',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.forma_prawna_typ_id' => '1',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.wykreslony' => '0',
                    ),
                );

            } elseif ($this->request->query['layer'] == 'krs') {

                $must[] = array(
                    'term' => array(
                        'dataset' => 'krs_podmioty',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.wykreslony' => '0',
                    ),
                );

            } elseif ($this->request->query['layer'] == 'ngo') {

                $must[] = array(
                    'term' => array(
                        'dataset' => 'krs_podmioty',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.forma_prawna_typ_id' => '2',
                    ),
                );

                $must[] = array(
                    'term' => array(
                        'data.krs_podmioty.wykreslony' => '0',
                    ),
                );

            } elseif ($this->request->query['layer'] == 'komisje_wyborcze') {

                $must[] = array(
                    'term' => array(
                        'dataset' => 'wybory_parl_obwody',
                    ),
                );

            }


            $precision = floor($strlen / 2);

            $options = array(
                'cover' => array(
                    'force' => true,
                    'aggs' => array(
                        'map' => array(
                            'scope' => 'global',
                            'filter' => array(
                                'bool' => array(
                                    'must' => $must,
                                    '_cache' => true,
                                ),
                            ),
                            'aggs' => array(
                                'grid' => array(
                                    'geohash_grid' => array(
                                        'field' => 'position',
                                        'precision' => $precision,
                                    ),
                                    'aggs' => array(
                                        'inner_grid' => array(
                                            'geohash_grid' => array(
                                                'field' => 'position',
                                                'precision' => $precision + 1,
                                                'size' => 1,
                                            ),
                                        ),
                                        'top' => array(
                                            'top_hits' => array(
                                                'size' => 1,
                                                'fielddata_fields' => array('position.lat', 'position.lon'),
                                                '_source' => false,
                                                'fields' => array(),
                                            ),
                                        ),
                                        /*
                                        'lat' => array(
                                            'terms' => array(
                                                'field' => 'position.lat',
                                                'size' => 1,
                                            ),
                                        ),
                                        'lng' => array(
                                            'terms' => array(
                                                'field' => 'position.lon',
                                                'size' => 1,
                                            ),
                                        ),
                                        'id' => array(
                                            'terms' => array(
                                                'field' => '_id',
                                                'size' => 1,
                                            ),
                                        ),
                                        */
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            );

            $this->Components->load('Dane.DataBrowser', $options);
            $this->set('_serialize', 'dataBrowser');


        } else {

            throw new BadRequestException('Required parameters missing');

        }

    }

    public function beforeRender()
    {

        parent::beforeRender();

        $this->setLayout(array('header' => false, 'footer' => false));

        if ($this->request->params['action'] == 'layer') {

            $data = $this->viewVars['dataBrowser']['aggs']['map'];
            foreach ($data['grid']['buckets'] as &$b) {

                if ($b['doc_count'] === 1) {

                    $b['location'] = array(
                        'lat' => $b['top']['hits']['hits'][0]['fields']['position.lat'][0],
                        'lon' => $b['top']['hits']['hits'][0]['fields']['position.lon'][0],
                    );

                    unset($b['top']);

                } else {

                    unset($b['top']);

                }

                $b['inner_key'] = $b['inner_grid']['buckets'][0]['key'];
                unset($b['inner_grid']);

            }

            $this->viewVars['dataBrowser'] = $data;

        } else {

            if (
                (@$this->viewVars['dataBrowser']['mode'] == 'cover') &&
                ($hits = @$this->viewVars['dataBrowser']['aggs']['miejsca']['top']['hits']['hits'])
            ) {

                $wojewodztwa = array();

                foreach ($hits as $h)
                    $wojewodztwa[] = array_merge($h['_source']['data'], $h['_source']['static']);

                $this->set('mapParams', array(
                    'mode' => 'start',
                    'title' => 'Mapa',
                    'children' => array(
                        'wojewodztwa' => $wojewodztwa,
                    ),
                    // 'viewport' => $viewport,
                ));

            }

        }

    }

    public function geodecode()
    {
        if (
            (@$this->request->params['ext'] == 'json') &&
            (isset($this->request->query['lat'])) &&
            (isset($this->request->query['lon']))
        ) {

            $data = $this->Mapa->geodecode($this->request->query['lat'], $this->request->query['lon']);
            $this->set('data', $data);
            $this->set('_serialize', 'data');

        } else {
            return $this->redirect('/mapa');
        }
    }
}
