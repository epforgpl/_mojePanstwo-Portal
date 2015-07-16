<?php

App::uses('DataobjectsController', 'Dane.Controller');

class BdlWskaznikiController extends DataobjectsController
{
    public $uses = array(
      'Bdl.BdlTempItem','Dane.Dataobject', 'Dane.Subscription', 'Dane.ObjectUsersManagement'
    );


    public $menu = array();
    public $components = array('RequestHandler');
    public $objectOptions = array(
        'bigTitle' => true,
    );

    public $initLayers = array('dimennsions', 'levels');
    public $addDatasetBreadcrumb = false;

    public function kombinacje()
    {
		 
		$this->setLayout(array(
            'footer' => array(
                'element' => 'minimal',
            ),
            'header' => array(
	            'element' => 'dataobject-bdl',
            ),
        )); 
		      
        parent::load();
        
        $expand_dimension = isset($this->request->query['i']) ? (int) $this->request->query['i'] : $this->object->getData('i');

        $dims = $this->object->getLayer('dimennsions');
        $levels = $this->object->getLayer('levels');
                    
        
        if (isset($this->request->query['d']) && $this->request->query['d']) {

            $dimmensions_array = array();
            for ($d = 0; $d < 5; $d++) {
                $dimmensions_array[] = isset($this->request->query['d' . $d]) ?
                    (int)$this->request->query['d' . $d] :
                    0;
            }
            
            $params = array(
                'dims' => $dimmensions_array,
                'wskaznik_id' => $this->object->getId(),
            );
            
            $cache_id = 'BDL/series/' . md5(serialize($params));
            $exp_data = Cache::read($cache_id, 'long');
            if( !$exp_data ) {
                
                $this->loadModel('Bdl.BDL');
                $exp_data = $this->BDL->getData($params);
                Cache::write($cache_id, $exp_data, 'long');
                
            }
                        
            $redirect_url = $this->object->getUrl();
            
            if(
	            !empty($exp_data) && 
	            isset( $exp_data[0] ) && 
	            isset( $exp_data[0]['id'] ) && 
	            ( $id = $exp_data[0]['id'] )
            )
	            $redirect_url .= '/kombinacje/' . $id;
	            
			return $this->redirect($redirect_url);
			
        }
			
        $selected_level_id = false;

        if (!empty($levels)) {

            if (isset($this->request->params['subaction']))
                $this->request->params['level'] = $this->request->params['subaction'];

            if (isset($this->request->params['level']) && in_array($this->request->params['level'], array(
                    'gminy',
                    'powiaty',
                    'wojewodztwa'
                ))
            ) {

                foreach ($levels as &$level) {
                    if ($level['id'] == $this->request->params['level']) {

                        $selected_level_id = $level['id'];
                        $level['selected'] = true;

                    }
                }

            }

            if (!$selected_level_id) {
                $levels[0]['selected'] = true;
                $selected_level_id = $levels[0]['id'];
            }

        }
                        
        $this->loadModel('Bdl.BDL');
        $combination = $this->BDL->getCombination(array(
	        'id' => $this->request->params['subid'],
	        'local' => $selected_level_id,
        ));
        
        $title = false;
                
        foreach( $dims as $i => &$d )
			foreach( $d['options'] as &$o )
				if( $o['id'] == $combination['dims'][ $i ] ) {
					
					$o['selected'] = true;
					if( $expand_dimension == $i )
						$title = $o['value'];
						                
                }
                                
        $this->set('dims', $dims);
        $this->set('levels', $levels);
        $this->set('title', $title);
        $this->set('levels_selected', $selected_level_id);
        $this->set('combination', $combination);
        $this->set('expand_dimension', $expand_dimension);

    }

    public function view()
    {

        parent::load();

        $this->setLayout(array(
            'footer' => array(
                'element' => 'minimal',
            ),
            'header' => array(
	            'element' => 'dataobject-bdl',
            ),
        ));
        

        $expand_dimension = isset($this->request->query['i']) ? (int) $this->request->query['i'] : $this->object->getData('i');
        $dims = $this->object->getLayer('dimennsions');
        $expanded_dimension = array();
		
        // building dimmensions array (it will be usefull as a parameter for future API calls

        $dimmensions_array = array();
        for ($d = 0; $d < 5; $d++) {

            $dvalue = 0;

            if ($d != $expand_dimension) {
                $dvalue = isset($this->request->query['d' . $d]) ?
                    (int)$this->request->query['d' . $d] :
                    (int)@$dims[$d]['options'][0]['id'];
            }

            $dimmensions_array[] = $dvalue;

        }
		
        // Setting selected dimmension

        $i = 0;
        foreach ($dims as &$dim) {
			
			if( isset($option) )
				unset( $option );
				
            foreach ($dim['options'] as &$option)
                $option['selected'] = ($option['id'] == $dimmensions_array[$i]);
			
			if( isset($option) )
				unset( $option );
			
            if ($expand_dimension == $i) {
								                
                $dimmensions_array[ $i ] = '!';                
                $params = array(
	                'dims' => $dimmensions_array,
	                'wskaznik_id' => $this->object->getId(),
	                'years' => true,
                );
                
                $cache_id = 'BDL/series/' . md5(serialize($params));
                $exp_data = Cache::read($cache_id, 'long');
                if( !$exp_data ) {
	                
	                $this->loadModel('Bdl.BDL');
	                $exp_data = $this->BDL->getData($params);
	                Cache::write($cache_id, $exp_data, 'long');
	                
                }
                                
                
                $expanded_dimension = $dim;
				
				if( isset($option) )
					unset( $option );
												
                foreach ($expanded_dimension['options'] as &$option) {

                    $temp_dimmensions_array = $dimmensions_array;
                    $temp_dimmensions_array[$i] = (int) $option['id'];
                                        
                    foreach( $exp_data as $ed ) {
	                    	                    
	                    if( $temp_dimmensions_array == $ed['dims'] ) {
		                    
		                    $option['data'] = $ed;
		                    break;
		                    
	                    }
	                    
                    }

                }

                if( isset($option) )
					unset( $option );

            }

            $i++;
        }

        $this->set('dims', $dims);
        $this->set('expand_dimension', $expand_dimension);
        $this->set('expanded_dimension', $expanded_dimension);
        $this->set('dimmensions_array', $dimmensions_array);

        $BdlTempItems = $this->BdlTempItem->searchAll();

        $this->set(array(
            'BdlTempItems' => $BdlTempItems,
            '_serialize' => array('BdlTempItems')
        ));

        $datasets = $this->getDatasets('bdl');

        $options = array(
            'searchTitle' => 'Szukaj w Banku Danych Lokalnych...',
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
                'aggs' => array(),
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


    }

    public function local_chart_data_for_dimmensions()
    {
        $dims = isset($this->request->query['dims']) ? $this->request->query['dims'] : 0;
        $localtype = isset($this->request->query['localtype']) ? $this->request->query['localtype'] : 0;
        $localid = isset($this->request->query['localid']) ? $this->request->query['localid'] : 0;

        $this->loadModel('Bdl.BDL');
        $data = $this->BDL->getLocalChartDataForDimmesions($dims, $localtype, $localid);

        $this->set('data', $data);
        $this->set('_serialize', array('data'));
    }

    public function chart_data_for_dimmensions()
    {

        $dims = isset($this->request->query['dims']) ? explode(',', $this->request->query['dims']) : array();

        $this->loadModel('Bdl.BDL');
        $data = $this->BDL->getChartDataForDimmesions($dims);

        $this->set('data', $data);
        $this->set('_serialize', array('data'));
    }

    public function legacy_redirect()
    {

        return $this->redirect('/dane/bdl_wskazniki/' . $this->request->params['id'] . '/kombinacje/' . $this->request->params['subid']);

    }
    
    public function beforeRender()
    {
	    
	    if( $this->hasUserRole('3') ) {
		    $this->addObjectEditable('bdl_opis');
		    $this->addObjectEditable('bdl_wymiar');
		}
	    	    
	    parent::beforeRender();
	 	
	 	if( $this->object ) {
	 	
		    $this->addBreadcrumb(array(
	            'href' => '/bdl/#kategoria_id=' . $this->object->getData('bdl_wskazniki.kategoria_id'),
	            'label' => '<span class="normalizeText">' . $this->object->getData('bdl_wskazniki.kategoria_tytul') . '</span>',
	        ));	
	        
	        $this->addBreadcrumb(array(
	            'href' => '/bdl/#kategoria_id=' . $this->object->getData('bdl_wskazniki.kategoria_id') . '&grupa_id=' . $this->object->getData('bdl_wskazniki.grupa_id'),
	            'label' => '<span class="normalizeText">' . $this->object->getData('bdl_wskazniki.grupa_tytul') . '</span>',
	        ));

        }

        $tree = Cache::read('BDL.tree', 'long');
        if (!$tree) {
            $this->loadModel('Bdl.BDL');
            $tree = $this->BDL->getTree();
            Cache::write('BDL.tree', $tree, 'long');
        }

        $this->set('tree', $tree);

    }    

} 