<?php

App::uses('ApplicationsController', 'Controller');
class SejmometrController extends ApplicationsController
{

    public $settings = array(
        'id' => 'sejmometr',
		'title' => 'Sejmometr',
		'subtitle' => 'Dane o pracy Sejmu i posłów',
		'headerImg' => 'sejmometr',
	);

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/sejmometr/img/social/sejmometr.jpg');
    }
	
	

    public function detailBlock()
    {

        $id = $this->request->query['id'];
        if (!$id) {
            return false;
        }

        $view = new View($this, false);

        $element = 'list_inner';
        if ($id == 'zawody') {
            $element = 'zawody';
        }

        $items = $this->poslowie($id);

        $html = $view->element('Sejmometr.' . $element, array(
            'items' => $items,
        ));

        $this->set('id', $id);
        $this->set('html', $html);
        $this->set('_serialize', array('html', 'id'));

    }

    public function poslowie()
    {
        $this->loadDatasetBrowser('poslowie');
    }

    public function posiedzenia_timeline()
    {

        $output = array(
            'timeline' => array(
                'headline' => 'Posiedzenia Sejmu RP',
                'type' => 'default',
                'date' => array(),
            ),
        );


        $API = $this->API->Dane();
        $API->searchDataset('sejm_posiedzenia', array(
            'order' => 'data_stop desc',
            'limit' => 100,
        ));

        foreach ($API->getObjects() as $object) {

            if ($object->getData('numer') == '0') {
                continue;
            }

            $startDate = $object->getData('data_start');
            $dateParts = explode('-', $startDate);
            $startDate = $dateParts[0] . ',' . $dateParts[1] . ',' . $dateParts[2];

            $stopDate = $object->getData('data_stop');
            $dateParts = explode('-', $stopDate);
            $stopDate = $dateParts[0] . ',' . $dateParts[1] . ',' . $dateParts[2];

            if (!$object->getData('komunikat_id')) {
                $asset = array(
                    'media' => '/Sejmometr/img/default.jpg',
                    'thumbnail' => '/Sejmometr/img/default-thumbnail.jpg',
                    'credit' => '',
                );
            } else {
                $asset = array(
                    'media' => 'http://resources.sejmometr.pl/sejm_komunikaty/img/' . $object->getData('komunikat_id') . '-0.jpg',
                    'thumbnail' => 'http://resources.sejmometr.pl/sejm_komunikaty/img/' . $object->getData('komunikat_id') . '-1.jpg',
                    'credit' => '® Kancelaria Sejmu',
                );
            }

            $output['timeline']['date'][] = array(
                'startDate' => $startDate,
                'endDate' => $stopDate,
                'headline' => '<a href="/dane/sejm_posiedzenia/' . $object->getData('id') . '">#' . $object->getData('numer') . '</a>',
                'text' => '<div class="slide_content" data-posiedzenie_id="' . $object->getId() . '">Ładowanie...</div>',
                'classname' => 'klasa',
                'asset' => $asset,
            );

        }

        $this->set('data', $output);
        $this->set('_serialize', 'data');

    }

    public function posiedzenie()
    {

        $id = (int)$this->request->params['id'];
        if (!$id) {
            return false;
        }

        $API = $this->API->Dane();
        $object = $API->getObject('sejm_posiedzenia', $id);


        $projekty = $object->loadLayer('projekty');

        $view = new View($this, false);
        $html = $view->element('Dane.sejmposiedzenie-projekty-cont', array(
            'projekty' => $projekty,
        ));


        $this->set('id', $id);
        $this->set('data', $object->getData());
        $this->set('projekty_html', $html);
        $this->set('_serialize', array('id', 'data', 'projekty_html'));

    }

    public function prace()
    {

        $q = (string)@$this->request->query['q'];

        $queryData = array(
            'includeContent' => true,
        );

        if ($q) {
            $queryData['conditions']['q'] = $q;
        }

        $API = $this->API->Sejmometr();
        $data = $API->getLatestData($queryData);

        $chapters = array(
            array(
                'id' => 'projekty_ustaw',
                'title' => 'Projekty ustaw',
            ),
            array(
                'id' => 'projekty_uchwal',
                'title' => 'Projekty uchwał',
            ),
            array(
                'id' => 'sprawozdania_kontrolne',
                'title' => 'Sprawozdania kontrolne',
            ),
            array(
                'id' => 'umowy',
                'title' => 'Umowy międzynarodowe',
            ),
            array(
                'id' => 'powolania_odwolania',
                'title' => 'Powołania i odwołania ze stanowisk',
            ),
            array(
                'id' => 'sklady_komisji',
                'title' => 'Zmiany w składach komisji sejmowych',
            ),
            array(
                'id' => 'referenda',
                'title' => 'Wnioski o referenda',
            ),
            array(
                'id' => 'inne',
                'title' => 'Inne projekty',
            ),
        );

        foreach ($chapters as &$chapter) {
            $chapter['search'] = $data[$chapter['id']];
        }


        $this->set('chapters', $chapters);


        /*
        if ($q && !empty($channels)) {
            foreach ($channels as &$ch) {

                $datachannel_count = 0;

                $facets = $ch['facets'];
                if (!empty($facets)) {

                    $facets = array_column($facets, 'params', 'field');

                    if (array_key_exists('dataset', $facets) &&
                        isset($facets['dataset']['options']) &&
                        !empty($facets['dataset']['options'])
                    ) {

                        $datasets = array_column($facets['dataset']['options'], 'count', 'id');

                        foreach ($ch['Dataset'] as &$d) {

                            if (array_key_exists($d['alias'], $datasets)) {
                                $d['count'] = $datasets[$d['alias']];
                                $datachannel_count += $d['count'];
                            } else {
                                $d['count'] = 0;
                            }

                        }

                    }
                }

                $ch['Datachannel']['score'] = 0;
                $ch['Datachannel']['count'] = $datachannel_count;


                if (!empty($ch['dataobjects']))
                    $ch['Datachannel']['score'] = $ch['dataobjects'][0]->getScore();

            }

            uasort($channels, array($this, 'channelsCompareMethod'));

        }


        $this->set('q', $q);
        $this->set('channels', $channels);
        $this->set('title_for_layout', 'Dane publiczne');
        */


    }

    public function szukaj()
    {

        $this->API = $this->API->Dane();
        $this->dataBrowser = $this->Components->load('Dane.DataobjectsBrowser', array(
            'source' => 'app:3',
            'title' => 'Szukaj w pracach Sejmu',
            'noResultsTitle' => 'Brak wyników',
        ));

    }

    public function autorzy_projektow()
    {

        $this->API = $this->API->Sejmometr();
        $data = $this->API->autorzy_projektow();

        $this->set('data', $data);
        $this->set('_serialize', 'data');

    }

    public function zawody_poslow()
    {
        $zawody = array_fill(0, 20, array(
            'name' => 'Prawnicy',
            'percent' => 10,
            'number' => 1,
        ));

        $total = 0;
        foreach ($zawody as $z) {
            $total += $z['number'];
        }

        $chart_max_percent = 3;
        $chart_max_items = 18;
        $ppl_in_graph = 0;
        $zawody_chart = array();
        for ($i = 0; $i < $chart_max_items; $i++) {
            if ($zawody[$i]['percent'] < $chart_max_percent) {
                break;
            }

            array_push($zawody_chart, $zawody[$i]);
            $ppl_in_graph += $z['number'];
        }
        array_push($zawody_chart, array(
            'name' => 'Inne',
            'percent' => ($total - $ppl_in_graph) * 1000 / $total * 0.1,
            'number' => $total - $ppl_in_graph
        ));

        $this->set(compact('zawody_chart', 'zawody'));
    }

    public function info()
    {
        $this->set(compact('info'));
    }

	public function view()
	{
		
		$this->menu_selected = 'poslowie';
        $this->loadDatasetBrowser('poslowie');
		
	}
	
	/*
    public function view()
    {
	    
	    
	    
        $datasets = $this->getDatasets('sejmometr');
	    
        $options  = array(
            'searchTitle' => 'Szukaj w danych sejmowych...',
            'conditions' => array(
	            'dataset' => array_keys($datasets),
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Sejmometr',
		            'element' => 'cover',
	            ),
	            'aggs' => array(
		            'druki' => array(
			            'filter' => array(
				            'term' => array(
								'dataset' => 'sejm_druki',
							),
			            ),
			            'aggs' => array(
				            'top' => array(
						        'top_hits' => array(
							        'size' => 3,
							        'fielddata_fields' => array('dataset', 'id'),
							        'sort' => array(
								        'date' => array(
									        'order' => 'desc',
								        ),
							        ),
						        ),
					        ),
			            ),
		            ),
		            'interpelacje' => array(
			            'filter' => array(
				            'term' => array(
								'dataset' => 'sejm_interpelacje',
							),
			            ),
			            'aggs' => array(
				            'top' => array(
						        'top_hits' => array(
							        'size' => 3,
							        'fielddata_fields' => array('dataset', 'id'),
							        'sort' => array(
								        'date' => array(
									        'order' => 'desc',
								        ),
							        ),
						        ),
					        ),
			            ),
		            ),
		            'komunikaty' => array(
			            'filter' => array(
				            'term' => array(
								'dataset' => 'sejm_komunikaty',
							),
			            ),
			            'aggs' => array(
				            'top' => array(
						        'top_hits' => array(
							        'size' => 3,
							        'fielddata_fields' => array('dataset', 'id'),
							        'sort' => array(
								        'date' => array(
									        'order' => 'desc',
								        ),
							        ),
						        ),
					        ),
			            ),
		            ),
		            'posiedzenia' => array(
			            'filter' => array(
				            'term' => array(
								'dataset' => 'sejm_posiedzenia',
							),
			            ),
			            'aggs' => array(
				            'top' => array(
						        'top_hits' => array(
							        'size' => 1,
							        'fielddata_fields' => array('dataset', 'id'),
							        'sort' => array(
								        'date' => array(
									        'order' => 'desc',
								        ),
							        ),
						        ),
					        ),
			            ),
		            ),
					'poslowie' => array(
						'filter' => array(
							'term' => array(
								'dataset' => 'poslowie',
							),
						),
						'aggs' => array(
							'klub_id' => array(
					            'terms' => array(
						            'field' => 'poslowie.klub_id',
						            'exclude' => array(
							            'pattern' => '0'
						            ),
					            ),
					            'aggs' => array(
						            'label' => array(
							            'terms' => array(
								            'field' => 'data.sejm_kluby.nazwa',
							            ),
						            ),
					            ),
					        ),
					        'zawod' => array(
					            'terms' => array(
						            'field' => 'poslowie.zawod',
						            'exclude' => array(
							            'pattern' => ''
						            ),
					            ),
					            'aggs' => array(
						            'label' => array(
							            'terms' => array(
								            'field' => 'poslowie.zawod',
							            ),
						            ),
					            ),
					        ),
					        'plec' => array(
				                'terms' => array(
				                    'field' => 'poslowie.plec',
				                    'include' => array(
				                        'pattern' => '(K|M)'
				                    ),
				                ),
				                'aggs' => array(
				                    'label' => array(
				                        'terms' => array(
				                            'field' => 'poslowie.plec',
				                        ),
				                    ),
				                ),
				            ),
						),
					),
	            ),
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
        
	    $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }
    */

    private function klub_img_src($klub_id)
    {
        // TODO use MP\Dane\Sejm_kluby::getThumbnailSrc
        return "http://resources.sejmometr.pl/s_kluby/" . $klub_id . "_a_t.png";
    }
}