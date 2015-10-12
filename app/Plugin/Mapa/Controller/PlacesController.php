<?php

App::uses('ApplicationsController', 'Controller');

class PlacesController extends ApplicationsController
{

    public $components = array('RequestHandler');

    public $settings = array(
        'id' => 'mapa',
        'title' => 'Mapa'
    );

	private $fields = array(
		'1' => 'wojewodztwa',
		'2' => 'powiaty',
		'3' => 'gminy',
		'4' => 'miejscowosci',
		'5' => 'ulice',
	);
	
    public function view($id)
    {
	    
	    $this->loadModel('Dane.Dataobject');
	    $place = $this->Dataobject->find('first', array(
		    'conditions' => array(
			    'dataset' => 'miejsca',
			    'id' => $id,
		    ),
		    'layers' => array(
			    'shapes'
		    ),
		    'aggs' => array(
			    'numery' => array(
				    'nested' => array(
					    'path' => 'miejsca-numery',
				    ),
				    'aggs' => array(
					    'numery' => array(
						    'top_hits' => array(
							    'size' => 10000,
							    'fielddata_fields' => array('numer', 'miejsca-numery.location.lat', 'miejsca-numery.location.lon', 'parl_obwod_id', 'kod_str'),
							    'sort' => array(
								    'miejsca-numery.numer_int' => array(
									    'order' => 'asc',
								    ),
							    ),
						    ),
					    ),
					    'viewport' => array(
							'geo_bounds' => array(
								'field' => 'miejsca-numery.location', 
							),
						),
						'kody' => array(
							'terms' => array(
								'field' => 'miejsca-numery.kod',
								'size' => 3,
							),
						),
						'parl_obwody' => array(
							'terms' => array(
								'field' => 'miejsca-numery.parl_obwod_id',
								'size' => 3,
							),
						),
				    ),
			    ),
			    'miejsca' => array(
				    'filter' => array(
					    'term' => array(
						    'dataset' => 'miejsca',
					    ),
				    ),
				    'aggs' => array(
					    'children' => array(
						    'nested' => array(
							    'path' => 'miejsca-parents',
						    ),
						    'aggs' => array(
							    '*' => array(
								    'filter' => array(
									    'term' => array(
										    'miejsca-parents.id' => $id,
									    ),
								    ),
								    'aggs' => array(
									    'reverse' => array(
										    'reverse_nested' => '_empty',
										    'aggs' => array(
											    'punkty' => array(
												    'nested' => array(
													    'path' => 'miejsca-numery',
												    ),
												    'aggs' => array(
													    'kody' => array(
															'terms' => array(
																'field' => 'miejsca-numery.kod',
																'size' => 3,
															),
														),
														'parl_obwody' => array(
															'terms' => array(
																'field' => 'miejsca-numery.parl_obwod_id',
																'size' => 3,
															),
														),
													    'viewport' => array(
															'geo_bounds' => array(
																'field' => 'miejsca-numery.location', 
															),
														),
												    ),
											    ),
										    ),
									    ),
									    'direct' => array(
										    'filter' => array(
											    'term' => array(
												    'miejsca-parents.distance' => 1,
											    ),
										    ),
										    'aggs' => array(
											    'reverse' => array(
												    'reverse_nested' => '_empty',
												    'aggs' => array(
													    'typy' => array(
														    'terms' => array(
															    'field' => 'data.miejsca.typ_id',
															    'size' => 5,
														    ),
														    'aggs' => array(
															    'top' => array(
																    'top_hits' => array(
																	    'size' => 10000,
																	    'sort' => array(
																		    'title.raw' => array(
																			    'order' => 'asc',
																		    ),
																	    ),
																    ),
															    ),
														    ),
													    ),
												    ),
											    ),
										    ),
									    ),
								    ),
							    ),
						    ),
					    ),
				    ),
				    'scope' => 'global',
			    ),
		    ),
	    ));
	    
	    	    
	    // $data = $this->getPlaceData($place);	    
	    // debug($data); die();
	    	    
	    $points = array();
	    $viewport = array();
	    $children = array();
	    $codes = array();
	    
	    
	    if( $aggs = $this->Dataobject->getAggs() ) {
			
			// debug($aggs); die();
			
			
			// VIEWPORT
			
			if( 
				@$aggs['miejsca']['children']['*']['reverse']['punkty']['viewport']['bounds'] && 
				@!$aggs['numery']['viewport']['bounds']
			) {
				
				$viewport = $aggs['miejsca']['children']['*']['reverse']['punkty']['viewport']['bounds'];
				
			} elseif(
				@!$aggs['miejsca']['children']['*']['reverse']['punkty']['viewport']['bounds'] && 
				@$aggs['numery']['viewport']['bounds']
			) {
				
				$viewport = $aggs['numery']['viewport']['bounds'];
				
			} elseif(
				@$aggs['miejsca']['children']['*']['reverse']['punkty']['viewport']['bounds'] && 
				@$aggs['numery']['viewport']['bounds']
			) {
				
				// TODO: calculate max viewport
				$viewport = $aggs['miejsca']['children']['*']['reverse']['punkty']['viewport']['bounds'];
				
			}
			
			
			
			
			
			// POSTAL CODES
						
			if( 
				@$aggs['miejsca']['children']['*']['reverse']['punkty']['kody']['buckets'] && 
				@!$aggs['numery']['kody']['buckets']
			) {
				
				$codes = $aggs['miejsca']['children']['*']['reverse']['punkty']['kody']['buckets'];
				
			} elseif(
				@!$aggs['miejsca']['children']['*']['reverse']['punkty']['kody']['buckets'] && 
				@$aggs['numery']['kody']['buckets']
			) {
				
				$codes = $aggs['numery']['kody']['buckets'];
				
			} elseif(
				@$aggs['miejsca']['children']['*']['reverse']['punkty']['kody']['buckets'] && 
				@$aggs['numery']['kody']['buckets']
			) {
				
				// TODO: calculate max
				$codes = $aggs['numery']['kody']['buckets'];
				
			}
			
			
			
			
			
			
			
						
			
			
			
			if( $typy = @$aggs['miejsca']['children']['*']['direct']['reverse']['typy']['buckets'] ) {
				foreach( $typy as $t ) {
					
					$field = $this->fields[ $t['key'] ];
					foreach( $t['top']['hits']['hits'] as $h )
						$children[ $field ][] = $h['fields']['source'][0]['data'];
											
				}
			}
						
			if( $_points = @$aggs['numery']['numery']['hits']['hits'] ) {
								
			    foreach( $_points as $_p ) {
				    
				    $p = array();
				    
				    if( @$_p['fields']['miejsca-numery.location.lon'][0] && @$_p['fields']['miejsca-numery.location.lat'][0] )
				    	$p['lat'] = $_p['fields']['miejsca-numery.location.lat'][0];
				    	$p['lon'] = $_p['fields']['miejsca-numery.location.lon'][0];
				    
				    if( @$_p['fields']['numer'][0] )
				    	$p['numer'] = $_p['fields']['numer'][0];
				    
				    if( !empty($p) )
					    $points[] = $p;
				    
			    }
		    
		    }
		    		    		    		    
	    }
	    
	    
	    $this->title = $place->getTitle();
		$this->set('mapParams', array(
			'mode' => 'place',
			'title' => $place->getTitle(),
		    'data' => $place->getData(),
		    'points' => $points,
		    'viewport' => $viewport,
		    'children' => $children,
		    'codes' => $codes,
		));
		
		
	   	
	   	if( isset($this->request->query['widget']) )
        	$this->layout = 'blank';
	   	                   
    }
    
    public function getPlaceData($object = false) {
	    	    
	    if( !is_object($object) )
	    	return false;
	    
	    $options = false;
	    
	    switch( $object->getData('typ_id') ) {
		    
		    case '4': {
			    
			    $options = array(
				    'aggs' => array(
					    'miejsca' => array(
						    'scope' => 'global',
						    'filter' => array(
							    'boolean' => array(
								    'must' => array(
									    array(
										    'term' => array(
											    'dataset' => 'miejsca',
										    ),
									    ),
								    ),
							    ),
						    ),
						    'aggs' => array(
							    'top' => array(
								    'top_hits' => array(
									    'size' => 1,
								    ),
							    ), 
						    ),
					    ),
				    ),
			    );
			    
			    break;
		    }
		    
	    }
	    
	    if( !$options )
	    	return false;
	    
	    $this->loadModel('Dane.Dataobject');
	    $this->Dataobject->find('all', array(
		    'limit' => 0,
		    'aggs' => $options['aggs'],
	    ));
	    
	    return $this->Dataobject->getDataSource()->Aggs;
	    	    
    }
    
}
