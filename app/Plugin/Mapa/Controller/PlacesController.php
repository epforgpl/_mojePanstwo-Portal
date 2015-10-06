<?php

App::uses('ApplicationsController', 'Controller');

class PlacesController extends ApplicationsController
{

    public $components = array('RequestHandler');

    public $settings = array(
        'id' => 'mapa',
        'title' => 'Mapa'
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
			    'points' => array(
				    'nested' => array(
					    'path' => 'miejsca-numery',
				    ),
				    'aggs' => array(
					    'points' => array(
						    'top_hits' => array(
							    'size' => 10000,
							    'fielddata_fields' => array('numer', 'miejsca-numery.location.lat', 'miejsca-numery.location.lon', 'parl_obwod_id', 'kod_str'),
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
	    ));
	    
	    $points = array();
	    $viewport = array();
	    
	    
	    if( $aggs = $this->Dataobject->getAggs() ) {
		    
			if( $_points = @$aggs['points']['points']['hits']['hits'] ) {
								
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
		    
		    if( @$aggs['points']['viewport']['bounds'] )
		    	$viewport = $aggs['points']['viewport']['bounds'];
		    		    		    
	    }
	    
	    $this->title = $place->getTitle();
	    	    
	    
	    $this->set('place', array(
		    'title' => $place->getTitle(),
		    'data' => $place->getData(),
		    'layers' => $place->getLayers(),
		    'points' => $points,
		    'viewport' => $viewport,
	    ));
	   	
	   	if( isset($this->request->query['widget']) ) {
        	$this->layout = 'blank';
        	$this->set('widget', true);
        }
	   	   
	    /*
        if ((@$this->request->params['ext'] == 'json') && (isset($this->request->query['q']))) {
            $data = $this->Mapa->geocode($this->request->query['q']);
            $this->set('data', $data);
            $this->set('_serialize', 'data');
        } else {
            $this->title = 'Mapa';
        }
        */
                
    }
}
