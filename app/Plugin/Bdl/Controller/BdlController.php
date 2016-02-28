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
		
		$this->loadModel('Dane.Dataobject');
		
		if( $object = $this->Dataobject->find('first', array(
			'conditions' => array(
				'dataset' => 'bdl_wskazniki_kategorie',
				'id' => $this->request->params['id'],
			),
		)) ) {
			
			return $this->redirect('/bdl#' . $object->getSlug());
			
		} else {
			
			return $this->redirect('/bdl');
			
		}
				
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
	            'cache' => true,
                'view' => array(
                    'plugin' => 'Bdl',
                    'element' => 'cover',
                ),
                'aggs' => array(
	                'wskazniki' => array(
		                'scope' => 'global',
		                'filter' => array(
			                'bool' => array(
				                'must' => array(
					                array(
						                'term' => array(
							                'dataset' => 'bdl_wskazniki',
						                ),
					                ),
					                /*
					                array(
						                'range' => array(
							                'data.bdl_wskazniki.liczba_ostatni_rok' => array(
								                'gte' => date('Y')-3
							                ),
						                ),
					                ),
					                */
				                ),
			                ),
		                ),
		                'aggs' => array(
			                'top' => array(
				                'top_hits' => array(
					                'size' => 1000,
					                'sort' => array(
						                'data.bdl_wskazniki.kategoria_tytul' => array(
							                'order' => 'asc',
						                ),
						                'data.bdl_wskazniki.grupa_tytul' => array(
							                'order' => 'asc',
						                ),
						                'title.raw' => array(
							                'order' => 'asc',
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
		
		$this->set('_edit', $this->hasUserRole('3'));
		
		if( $hits = @$this->viewVars['dataBrowser']['aggs']['wskazniki']['top']['hits']['hits'] ) {
						
			$tree = array();
			foreach( $hits as $h ) {
								
				$h = $h['_source']['data'];
				
				$tree[ $h['bdl_wskazniki']['kategoria_id'] ]['kategoria'] = array(
					'id' => $h['bdl_wskazniki']['kategoria_id'],
					'nazwa' => $h['bdl_wskazniki']['kategoria_tytul'],
					'slug' => @$h['bdl_wskazniki']['kategoria_slug'],
				);
				$tree[ $h['bdl_wskazniki']['kategoria_id'] ]['grupy'][ $h['bdl_wskazniki']['grupa_id'] ]['grupa'] = array(
					'id' => $h['bdl_wskazniki']['grupa_id'],
					'nazwa' => $h['bdl_wskazniki']['grupa_tytul'],
					'slug' => @$h['bdl_wskazniki']['grupa_slug'],
				);
				$tree[ $h['bdl_wskazniki']['kategoria_id'] ]['grupy'][ $h['bdl_wskazniki']['grupa_id'] ]['wskazniki'][] = $h;
				
			}
			
			unset( $this->viewVars['dataBrowser']['aggs']['wskazniki'] );
			$tree = array_values( $tree );			
			
			$this->set('tree', $tree);
			
		}
		
    }
    
    public function getChapters() {
	    return array();
	}

}
