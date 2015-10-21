<?php

App::uses('ApplicationsController', 'Controller');

class BdlController extends ApplicationsController
{

    public $settings = array(
        'id' => 'bdl',
        'title' => 'Bdl',
        'subtitle' => 'Dane statystyczne o Polsce',
        'headerImg' => 'bdl',
    );

    public $mainMenuLabel = 'Przeglądaj';

	public function kategorie()
	{

		$datasets = $this->getDatasets('bdl');

        $options = array(
            'searchTag' => array(
	            'href' => '/bdl',
	            'label' => 'Bank Danych Lokalnych',
            ),
            'searchAction' => '/bdl',
            'autocompletion' => array(
                'dataset' => 'bdl_wskazniki',
            ),
            'conditions' => array(
                'dataset' => 'bdl_wskazniki',
                'bdl_wskazniki.kategoria_id'  => $this->request->params['id'],
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Bdl',
                    'element' => 'kategoria',
                ),
                'aggs' => array(
	                'kategorie' => array(
		                'filter' => array(
			                'term' => array(
				                'dataset' => 'bdl_wskazniki_kategorie',
			                ),
		                ),
		                'scope' => 'global',
		                'aggs' => array(
			                'id' => array(
				                'terms'=> array(
					                'field' => 'title.raw',
					                'size' => 100,
					                'order' => array(
					                	'_term' => 'asc',
					                ),
				                ),
				                'aggs' => array(
					                'id' => array(
						                'terms' => array(
							                'field' => 'id',
							                'size' => 1,
						                ),
					                ),
				                ),
			                ),
		                ),
		                'visual' => array(
	                        'skin' => 'chapters',
	                        'field' => 'kategoria',
	                        'target' => 'menu',
	                    ),
	                ),
	                'grupy' => array(
		                'terms' => array(
			                'field' => 'bdl_wskazniki.grupa_id',
			                'size' => 100,
		                ),
		                'aggs' => array(
			                'label' => array(
				                'terms' => array(
					                'field' => 'bdl_wskazniki.grupa_tytul_raw',
					                'size' => 1,
				                ),
			                ),
			                'top' => array(
				                'top_hits' => array(
					                'size' => 100,
					                'fielddata_fields' => array('dataset', 'id'),
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
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                        'target' => false,
                    ),
                ),
            ),
            'apps' => true,
            'routes' => array(
	            'kategorie/kategoria_id' => 'kategorie',
	            'kategorie/grupa_id' => 'grupy',
            ),
        );

		$this->chapter_selected = $this->request->params['id'];

        $this->Components->load('Dane.DataBrowser', $options);
        $this->title = 'Bank Danych Lokalnych';
        $this->set('kategoria_id', $this->request->params['id']);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

	}

    public function view()
    {
        $datasets = $this->getDatasets('bdl');

        $options = array(
            'searchTag' => array(
	            'href' => '/bdl',
	            'label' => 'Bank Danych Lokalnych',
            ),
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
                'aggs' => array(
	                'kategorie' => array(
		                'filter' => array(
			                'term' => array(
				                'dataset' => 'bdl_wskazniki_kategorie',
			                ),
		                ),
		                'aggs' => array(
			                'id' => array(
				                'terms'=> array(
					                'field' => 'title.raw',
					                'size' => 100,
					                'order' => array(
					                	'_term' => 'asc',
					                ),
				                ),
				                'aggs' => array(
					                'id' => array(
						                'terms' => array(
							                'field' => 'id',
							                'size' => 1,
						                ),
					                ),
				                ),
			                ),
		                ),
		                'visual' => array(
	                        'skin' => 'chapters',
	                        'field' => 'kategoria',
	                        'target' => 'menu',
	                    ),
	                ),
                ),
            ),
            'aggs' => array(
                'kategorie' => array(
		            'terms' => array(
			            'field' => 'bdl_wskazniki_kategorie.id',
			            'size' => 100,
		            ),
		            'aggs' => array(
			            'id' => array(
				            'terms' => array(
					            'field' => 'data.bdl_wskazniki_kategorie.tytul',
					            'size' => 1,
				            ),
			            ),
		            ),
	            ),
            ),
            'apps' => true,
            'routes' => array(
	            'kategorie/id' => 'kategorie',
            ),
        );


        $this->Components->load('Dane.DataBrowser', $options);
        $this->title = 'Bank Danych Lokalnych - Wskaźniki statystyczne dotyczące sytuacji społecznej i gospodarczej Polski.';
        $this->render('Dane.Elements/DataBrowser/browser-from-app');


    }

    public function beforeRender() {

        parent::beforeRender();

        if (
            @$this->request->params['id'] &&
	    	( $items = @$this->viewVars['dataBrowser']['aggs']['kategorie']['buckets'] )
	    ) {
	    	foreach( $items as $item ) {
	    		if( $item['key'] == $this->request->params['id'] ) {

                    $this->set('title_for_layout', $item['label']['buckets'][0]['key'] . ' - Bank Danych Lokalnych');
		    		break;

                }
	    	}
	    }

    }

    public function getChapters() {

        $mode = false;
        $items = array();

		if(
            isset($this->request->query['q']) &&
			$this->request->query['q']
		) {

            $items[] = array(
				'id' => '_results',
				'label' => 'Wyniki wyszukiwania:',
				'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
			);

            if( $this->chapter_selected=='view' )
				$this->chapter_selected = '_results';
			$mode = 'results';

        } else {

            $items[] = array(
				'label' => 'Start',
				'href' => '/' . $this->settings['id'],
			);
		}

        if( isset($this->viewVars['dataBrowser']['aggs']['kategorie']['id']) )
			$buckets = $this->viewVars['dataBrowser']['aggs']['kategorie']['id']['buckets'];
		else
			$buckets = $this->viewVars['dataBrowser']['aggs']['kategorie']['buckets'];


        if( $buckets ) {
			foreach( $buckets as $b ) {


                $item = array(
					'label' => $b['key'],
					'id' => $b['id']['buckets'][0]['key'],
					'href' => '/' . $this->settings['id'] . '/kategorie/' . $b['id']['buckets'][0]['key'],
					'icon' => 'icon-datasets-bdl_wskazniki_kategorie',
				);

                if( $mode == 'results' ) {

                    $item['href'] .= '?q=' . urlencode( $this->request->query['q'] );

                } else {

                    $items[] = $item;

                }


            }
		}

        $output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

        return $output;

    }

}
