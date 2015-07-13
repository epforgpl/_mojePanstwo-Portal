<?php
class HighstockBrowserController extends AppController {
	
	public $uses = array('Dane.Dataobject');
	
	public function aggs() {
		
		$date_min = isset( $this->request->query['request']['date_min'] ) ? $this->request->query['request']['date_min'] : '*';
		$date_max = isset( $this->request->query['request']['date_max'] ) ? $this->request->query['request']['date_max'] : '*';
		
		$params = array(
			'limit' => 0,
			'conditions' => array(
				'dataset' => 'krakow_umowy',
				'date' => '[' . $date_min . ' TO ' . $date_max . ' ]',
			),
			'aggs' => array(
				'stats' => array(
					'stats' => array(
						'field' => 'krakow_umowy.wartosc_brutto',
					),
				),
				'umowy' => array(
					'top_hits' => array(
						'size' => 5,
                        'fielddata_fields' => array('dataset', 'id'),
						'sort' => array(
							'data.krakow_umowy.wartosc_brutto' => 'desc',
						),
					),
				),
				'wykonawcy' => array(
					'terms' => array(
						'field' => 'krakow_umowy.wykonawca_id',
						'size' => 3,
						'order' => array(
							'wartosc_brutto' => 'desc',
						),
					),
					'aggs' => array(
						'label' => array(
							'terms' => array(
								'field' => 'data.krakow_umowy_wykonawcy.nazwa',
								'size' => 1,
							),
						),
						'wartosc_brutto' => array(
							'sum' => array(
								'field' => 'data.krakow_umowy.wartosc_brutto',
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