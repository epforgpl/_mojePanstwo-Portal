<?php
class HighstockBrowserController extends AppController {
	
	public $uses = array('Dane.Dataobject');
	
	public function aggs() {
				
		$date_min = isset( $this->request->query['request']['date_min'] ) ? $this->request->query['request']['date_min'] : '*';
		$date_max = isset( $this->request->query['request']['date_max'] ) ? $this->request->query['request']['date_max'] : '*';
		
		$params = array(
			'limit' => 0,
			'conditions' => array(
				'dataset' => 'krakow_contracts',
				'date' => '[' . $date_min . ' TO ' . $date_max . ']',
			),
			'aggs' => array(
				'stats' => array(
					'stats' => array(
						'field' => 'krakow_contracts.kwota',
					),
				),
				'umowy' => array(
					'top_hits' => array(
						'size' => 5,
                        'fielddata_fields' => array('dataset', 'id'),
						'sort' => array(
							'data.krakow_contracts.kwota' => 'desc',
						),
					),
				),
				'wykonawcy' => array(
					'terms' => array(
						'field' => 'krakow_contracts.kontrahent',
						'size' => 10,
						'order' => array(
							'wartosc_brutto' => 'desc',
						),
					),
					'aggs' => array(
						'label' => array(
							'terms' => array(
								'field' => 'data.krakow_contracts.kontrahent',
								'size' => 1,
							),
						),
						'wartosc_brutto' => array(
							'sum' => array(
								'field' => 'data.krakow_contracts.kwota',
							),
						),
					),
				),
				'rodzaje_budzet' => array(
					'terms' => array(
						'field' => 'krakow_contracts.rodzaj',
						'size' => 10,
						'order' => array(
							'wartosc_brutto' => 'desc',
						),
					),
					'aggs' => array(
						'label' => array(
							'terms' => array(
								'field' => 'data.krakow_contracts.wytlumaczenie',
								'size' => 1,
							),
						),
						'wartosc_brutto' => array(
							'sum' => array(
								'field' => 'data.krakow_contracts.kwota',
							),
						),
					),
				),
				'rodzaje_wolumen' => array(
					'terms' => array(
						'field' => 'krakow_contracts.rodzaj',
						'size' => 10,
					),
					'aggs' => array(
						'label' => array(
							'terms' => array(
								'field' => 'data.krakow_contracts.wytlumaczenie',
								'size' => 1,
							),
						),
					),
				),
				'jednostki' => array(
					'terms' => array(
						'field' => 'krakow_contracts.jednostka_realizująca',
						'size' => 10,
					),
					'aggs' => array(
						'label' => array(
							'terms' => array(
								'field' => 'data.krakow_contracts.jednostka_realizująca_rozwiniecie',
								'size' => 1,
							),
						),
					),
				),
				'tryby' => array(
					'terms' => array(
						'field' => 'krakow_contracts.tryb',
						'size' => 10,
					),
					'aggs' => array(
						'label' => array(
							'terms' => array(
								'field' => 'data.krakow_contracts.tryb',
								'size' => 1,
							),
						),
					),
				),
			),
		);
				
		$this->Dataobject->find('all', $params);
		$aggs = $this->Dataobject->getAggs();
	    $this->set('aggs', $aggs);
	    	    
	    if( @$this->request->params['ext']=='html' ) {
		    
		    $this->layout = false;
		    $this->view = 'aggs-html';
		    
	    } else {
	    	    	    	    
	        $this->set('_serialize', 'aggs');
        
        }
		
	}
	
}