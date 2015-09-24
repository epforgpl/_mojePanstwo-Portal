<?php

App::uses('StartAppController', 'Start.Controller');

class StartController extends StartAppController
{

    public function view()
    {

        $datasets = $this->getDatasets('prawo');
        $_datasets = array_keys($datasets);

        $options = array(
            'searchTitle' => 'Szukaj w prawie...',
            'autocompletion' => array(
                'dataset' => 'prawo,prawo_hasla',
            ),
            'conditions' => array(
                'dataset' => $_datasets,
            ),
            'aggs' => array_merge(array(), $this->getChaptersAggs()),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Start',
                    'element' => 'cover',
                ),
                'aggs' => array(
                    'news' => array(
	                    'scope' => 'global',
	                    'filter' => array(
		                    'bool' => array(
			                    'must' => array(
				                    array(
					                    'term' => array(
						                    'dataset' => 'sejm_komunikaty',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.sejm_komunikaty.typ_id' => '0',
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
	                    'aggs' => array(
		                    'top' => array(
			                    'top_hits' => array(
				                    'size' => 5,
				                    'fielddata_fields' => array('dataset', 'id'),
				                    'sort' => array(
					                    'date' => 'desc',
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                    'konstytucja' => array(
	                    'filter' => array(
		                    'bool' => array(
			                    'must' => array(
				                    array(
					                    'term' => array(
						                    'dataset' => 'prawo',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.prawo.konstytucja' => '1',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.prawo.status_id' => '1',
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
	                    'scope' => 'global',
	                    'aggs' => array(
		                    'top' => array(
			                    'top_hits' => array(
				                    'size' => 10,
				                    'fielddata_fields' => array('dataset', 'id'),
				                    'sort' => array(
					                    'title.raw' => 'asc',
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                    'kodeksy' => array(
	                    'filter' => array(
		                    'bool' => array(
			                    'must' => array(
				                    array(
					                    'term' => array(
						                    'dataset' => 'prawo',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.prawo.kodeks' => '1',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.prawo.status_id' => '1',
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
	                    'scope' => 'global',
	                    'aggs' => array(
		                    'top' => array(
			                    'top_hits' => array(
				                    'size' => 10,
				                    'fielddata_fields' => array('dataset', 'id'),
				                    'sort' => array(
					                    'title.raw' => 'asc',
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                ),
            ),
            'apps' => true,
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

    public function getChapters() {

		$mode = false;

		$items = array(
			array(
				'label' => 'Start',
				'href' => '/' . $this->settings['id'],
			),
		);

		if( isset($this->viewVars['dataBrowser']['aggs']['dataset']) && !empty($this->viewVars['dataBrowser']['aggs']['dataset']) ) {

			$keys = array();
			foreach( $this->viewVars['dataBrowser']['aggs']['dataset'] as $k => $v )
				if( @$v['doc_count'] )
					$keys[] = $k;

			$items[] = array(
				'id' => '_results',
				'label' => 'Wyniki wyszukiwania',
				'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
			);

			if( $this->chapter_selected=='view' )
				$this->chapter_selected = '_results';
			$mode = 'results';


			foreach( $this->submenus['prawo']['items'] as $item ) {
				if( in_array($item['id'], $keys) ) {
					$item['href'] .= '?q=' . urlencode( $this->request->query['q'] );
					$items[] = $item;
				}
			}


		} else {

			$items = array_merge($items, $this->submenus['start']['items']);

		}

		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}

    private function getChaptersAggs() {

	    if( isset($this->request->query['q']) && $this->request->query['q'] ) {

		    return array(
		    	'dataset' => array(
				    'filter' => array(
					    'match_all' => '_empty',
				    ),
				    'scope' => 'query',
				    'aggs' => array(
					    'aktualnosci' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'sejm_komunikaty',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.sejm_komunikaty.typ_id' => '0',
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'ustawy' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'prawo',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.prawo.typ_id' => '1',
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'rozporzadzenia' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'prawo',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.prawo.typ_id' => '3',
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'umowy' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'prawo',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.prawo.typ_id' => array('6', '7', '8', '10', '11', '12'),
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'inne' => array(
						    'filter' => array(
							    'bool' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'prawo',
										    ),
									    ),
									    array(
										    'term' => array(
											    'data.prawo.typ_id' => array('0', '2', '4', '5', '9', '13', '14', '15'),
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
					    'lokalne' => array(
						    'filter' => array(
							    'term' => array(
								    'dataset' => 'prawo_wojewodztwa',
							    ),
						    ),
					    ),
					    'urzedowe' => array(
						    'filter' => array(
							    'term' => array(
								    'dataset' => 'prawo_urzedowe',
							    ),
						    ),
					    ),
				    ),
				),
		    );

	    } else return array();

    }

}
