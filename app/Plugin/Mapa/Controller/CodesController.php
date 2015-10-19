<?php

App::uses('ApplicationsController', 'Controller');

class CodesController extends ApplicationsController
{

    public $components = array('RequestHandler');

    public $settings = array(
        'id' => 'mapa',
        'title' => 'Mapa'
    );

    public function view($code)
    {
	    
	    $this->loadModel('Mapa.Mapa');
	    $code = $this->Mapa->getCode( $code );	    
				
	    $this->title = @$code['kod']['slug'];
		
		$gminy = $code['gminy'];
				
	    $mapParams = array(
		    'mode' => 'code',
		    'title' => $this->title,
		    'viewport' => $code['viewport'],
		    'gminy' => $gminy,
	    );
	    
	    $mapParams['children']['miejsca'] = $code['miejsca'];
	    
	    /*
	    if( @$code['wojewodztwa'] ) {
		    if( count($code['wojewodztwa'])===1 ) {
		    	$mapParams['wojewodztwo'] = array(
			    	'id' => $code['wojewodztwa'][0]['key'],
			    	'label' => @$code['wojewodztwa'][0]['label']['buckets'][0]['key'],
			    	'miejsce_id' => @$code['wojewodztwa'][0]['miejsce_id']['buckets'][0]['key'],
		    	);
		    } else {
			    foreach($code['wojewodztwa'] as &$i) {
				    $i = array(
					    'miejsca.wojewodztwo' => @$i['label']['buckets'][0]['key'],
					    'miejsca.id' => @$i['miejsce_id']['buckets'][0]['key'],
				    );
			    }
			    $mapParams['children']['wojewodztwa'] = $code['wojewodztwa'];
			}
		}
	    
	    
	    if( @$code['powiaty'] ) {    
		    if( count($code['powiaty'])===1 ) {
		    	$mapParams['powiat'] = array(
			    	'id' => $code['powiaty'][0]['key'],
			    	'label' => @$code['powiaty'][0]['label']['buckets'][0]['key'],
			    	'miejsce_id' => @$code['powiaty'][0]['miejsce_id']['buckets'][0]['key'],
		    	);
		    } else {
			    foreach($code['powiaty'] as &$i) {
				    $i = array(
					    'miejsca.powiat' => @$i['label']['buckets'][0]['key'],
					    'miejsca.id' => @$i['miejsce_id']['buckets'][0]['key'],
				    );
			    }
			    $mapParams['children']['powiaty'] = $code['powiaty'];
			}
	    }
	    	    
	    if( @$code['gminy'] ) {
		    if( count($code['gminy'])===1 ) {
		    	$mapParams['gmina'] = array(
			    	'id' => $code['gminy'][0]['key'],
			    	'label' => @$code['gminy'][0]['label']['buckets'][0]['key'],
			    	'miejsce_id' => @$code['gminy'][0]['miejsce_id']['buckets'][0]['key'],
		    	);
		    } else {
			    foreach($code['gminy'] as &$i) {
				    $i = array(
					    'miejsca.gmina' => @$i['label']['buckets'][0]['key'],
					    'miejsca.id' => @$i['miejsce_id']['buckets'][0]['key'],
				    );
			    }
			    $mapParams['children']['gminy'] = $code['gminy'];
			}
	    }
	    
	    
	    
	    if( @$code['miejscowosci'] ) {
		    if( count($code['miejscowosci'])===1 ) {
		    	$mapParams['miejscowosc'] = array(
			    	'id' => $code['miejscowosci'][0]['key'],
			    	'label' => @$code['miejscowosci'][0]['label']['buckets'][0]['key'],
			    	'miejsce_id' => @$code['miejscowosci'][0]['miejsce_id']['buckets'][0]['key'],
		    	);
		    } else {
			    foreach($code['miejscowosci'] as &$i) {
				    $i = array(
					    'miejsca.miejscowosc' => @$i['label']['buckets'][0]['key'],
					    'miejsca.id' => @$i['miejsce_id']['buckets'][0]['key'],
				    );
			    }
			    $mapParams['children']['miejscowosci'] = $code['miejscowosci'];
			}
	    }
	    
	    if( @$code['ulice'] ) {
		    if( count($code['ulice'])===1 ) {
		    	$mapParams['ulica'] = array(
			    	'id' => $code['ulice'][0]['key'],
			    	'label' => @$code['ulice'][0]['label']['buckets'][0]['key'],
			    	'miejsce_id' => @$code['ulice'][0]['miejsce_id']['buckets'][0]['key'],
		    	);
		    } else {
			    foreach($code['ulice'] as &$i) {
				    $i = array(
					    'miejsca.ulica' => @$i['label']['buckets'][0]['key'],
					    'miejsca.id' => @$i['miejsce_id']['buckets'][0]['key'],
				    );
			    }
			    $mapParams['children']['ulice'] = $code['ulice'];
			}
	    }
	    */
	    	
	    	    
	    $this->set('mapParams', $mapParams);
	   	
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
