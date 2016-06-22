<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PrawoHaslaController extends DataobjectsController
{

    public $headerObject = array('url' => '/dane/img/headers/prawne.jpg', 'height' => '250px');
    public $observeOptions = true;
    public $objectOptions = array(
        'hlFields' => array(),
    );

    public function view()
    {
				
        $this->_prepareView();
		
		if( 
			( @$this->request->params['ext'] != 'json' ) && 
			$this->object->getData('instytucja_id')
		) {
			return $this->redirect( $this->object->getUrl() );
		}
				
        $options = array(
            'searchTitle' => 'Szukaj w temacie...',
            'conditions' => array(
                // 'dataset' => 'prawo',
                '_feed' => array(
                    'dataset' => 'prawo_hasla',
                    'object_id' => $this->object->getId(),
                ),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'prawo_hasla/cover',
                ),
                'aggs' => array(
                    
                    'prawo' => array(
	                    'scope' => 'global',
	                    'filter' => array(
		                    'bool' => array(
			                    'must' => array(
				                    array(
					                    'terms' => array(
						                    'dataset' => array('dziennik_ustaw', 'monitor_polski'),
					                    ),
				                    ),
				                    array(
					                    'nested' => array(
						                    'path' => 'prawo-hasla',
						                    'filter' => array(
							                    'term' => array(
								                    'prawo-hasla.id' => $this->object->getId(),
							                    ),
						                    ),
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
	                    'aggs' => array(
		                    'ustawy' => array(
		                        'filter' => array(
			                        'or' => array(
				                        array(
					                        'term' => array(
				                                'data.dziennik_ustaw.typ_id' => '1',
				                            ),
				                        ),
				                        array(
					                        'term' => array(
				                                'data.monitor_polski.typ_id' => '1',
				                            ),
				                        ),
			                        ),
		                        ),
		                        'aggs' => array(
		                            'top' => array(
		                                'top_hits' => array(
		                                    'size' => 3,
		                                    'fielddata_fields' => array('dataset', 'id'),
		                                    '_source' => 'data.*',
		                                    'sort' => array(
			                                    array(
				                                    'prawo-hasla.score' => array(
					                                    'order' => 'desc',
					                                    'nested_path' => 'prawo-hasla',
					                                    'nested_filter' => array(
						                                    'term' => array(
							                                    'prawo-hasla.id' => $this->object->getId(),
						                                    ),
					                                    ),
				                                    )
			                                    ),
		                                    ),
		                                ),
		                            ),
		                        ),
		                    ),
		                    'rozporzadzenia' => array(
		                        'filter' => array(
		                            'or' => array(
			                            array(
				                            'term' => array(
				                                'data.dziennik_ustaw.typ_id' => '3',
				                            ),
			                            ),
			                            array(
				                            'term' => array(
				                                'data.monitor_polski.typ_id' => '3',
				                            ),
			                            ),
		                            ),
		                        ),
		                        'aggs' => array(
		                            'top' => array(
		                                'top_hits' => array(
		                                    'size' => 3,
		                                    'fielddata_fields' => array('dataset', 'id'),
		                                    '_source' => 'data.*',
		                                    'sort' => array(
			                                    array(
				                                    'prawo-hasla.score' => array(
					                                    'order' => 'desc',
					                                    'nested_path' => 'prawo-hasla',
					                                    'nested_filter' => array(
						                                    'term' => array(
							                                    'prawo-hasla.id' => $this->object->getId(),
						                                    ),
					                                    ),
				                                    )
			                                    ),
		                                    ),
		                                ),
		                            ),
		                        ),
		                    ),
		                    'inne' => array(
		                        'filter' => array(
		                            'bool' => array(
		                                'must_not' => array(
		                                    array(
			                                    'or' => array(
				                                    array(
					                                    'term' => array('data.dziennik_ustaw.typ_id' => '1')
				                                    ),
				                                    array(
					                                    'term' => array('data.monitor_polski.typ_id' => '1')
				                                    ),
			                                    ),
		                                    ),
		                                    array(
			                                    'or' => array(
				                                    array(
					                                    'term' => array('data.dziennik_ustaw.typ_id' => '3')
				                                    ),
				                                    array(
					                                    'term' => array('data.monitor_polski.typ_id' => '3')
				                                    ),
			                                    ),
		                                    ),
		                                ),
		                            ),
		                        ),
		                        'aggs' => array(
		                            'top' => array(
		                                'top_hits' => array(
		                                    'size' => 3,
		                                    'fielddata_fields' => array('dataset', 'id'),
		                                    '_source' => 'data.*',
		                                    'sort' => array(
			                                    array(
				                                    'prawo-hasla.score' => array(
					                                    'order' => 'desc',
					                                    'nested_path' => 'prawo-hasla',
					                                    'nested_filter' => array(
						                                    'term' => array(
							                                    'prawo-hasla.id' => $this->object->getId(),
						                                    ),
					                                    ),
				                                    )
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
        );

        $this->Components->load('Dane.DataBrowser', $options);

    }

    public function getMenu()
    {
				
        $menu = array(
            'items' => array(),
            'base' => $this->object->getUrl(),
        );

        $menu['items'][] = array(
            'label' => 'Temat',
        );
        
        $all = false;
        
        if( @$this->viewVars['dataBrowser']['aggs']['prawo']['ustawy']['doc_count'] ) {
        	$all = true;
        	$menu['items'][] = array(
	            'id' => 'ustawy',
	            'label' => 'Ustawy',
	        );
	    }
	        
	    if( @$this->viewVars['dataBrowser']['aggs']['prawo']['rozporzadzenia']['doc_count'] ) {
        	$all = true;
        	$menu['items'][] = array(
	            'id' => 'rozporzadzenia',
	            'label' => 'Rozporządzenia',
	        );
	    }
	        
	    if( @$this->viewVars['dataBrowser']['aggs']['prawo']['inne']['doc_count'] ) {
        	$all = true;
        	$menu['items'][] = array(
	            'id' => 'inne',
	            'label' => 'Pozostałe akty',
	        );
	    }
	    
	    if( $all )
	    	$menu['items'][] = array(
	            'id' => 'wszystkie',
	            'label' => 'Wszystkie akty',
	        );

        return $menu;

    }

    public function ustawy()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'dziennik_ustaw',
                'dziennik_ustaw.typ_id' => 1,
                'prawo-hasla:prawo-hasla.id' => $this->object->getId(),
            ),
            'aggs' => array(
                    
                'prawo' => array(
                    'scope' => 'global',
                    'filter' => array(
	                    'bool' => array(
		                    'must' => array(
			                    array(
				                    'terms' => array(
					                    'dataset' => array('dziennik_ustaw', 'monitor_polski'),
				                    ),
			                    ),
			                    array(
				                    'nested' => array(
					                    'path' => 'prawo-hasla',
					                    'filter' => array(
						                    'term' => array(
							                    'prawo-hasla.id' => $this->object->getId(),
						                    ),
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                    'aggs' => array(
	                    'ustawy' => array(
	                        'filter' => array(
		                        'or' => array(
			                        array(
				                        'term' => array(
			                                'data.dziennik_ustaw.typ_id' => '1',
			                            ),
			                        ),
			                        array(
				                        'term' => array(
			                                'data.monitor_polski.typ_id' => '1',
			                            ),
			                        ),
		                        ),
	                        ),
	                    ),
	                    'rozporzadzenia' => array(
	                        'filter' => array(
	                            'or' => array(
		                            array(
			                            'term' => array(
			                                'data.dziennik_ustaw.typ_id' => '3',
			                            ),
		                            ),
		                            array(
			                            'term' => array(
			                                'data.monitor_polski.typ_id' => '3',
			                            ),
		                            ),
	                            ),
	                        ),
	                    ),
	                    'inne' => array(
	                        'filter' => array(
	                            'bool' => array(
	                                'must_not' => array(
	                                    array(
		                                    'or' => array(
			                                    array(
				                                    'term' => array('data.dziennik_ustaw.typ_id' => '1')
			                                    ),
			                                    array(
				                                    'term' => array('data.monitor_polski.typ_id' => '1')
			                                    ),
		                                    ),
	                                    ),
	                                    array(
		                                    'or' => array(
			                                    array(
				                                    'term' => array('data.dziennik_ustaw.typ_id' => '3')
			                                    ),
			                                    array(
				                                    'term' => array('data.monitor_polski.typ_id' => '3')
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
        ));

        $this->set('title_for_layout', "Ustawy dla tematu " . $this->object->getTitle());

    }
    
    public function rozporzadzenia()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'dziennik_ustaw',
                'OR' => array(
                	'data.monitor_polski.typ_id' => 3,
                	'data.dziennik_ustaw.typ_id' => 3,
                ),
                'prawo-hasla:prawo-hasla.id' => $this->object->getId(),
            ),
            'aggs' => array(
                    
                'prawo' => array(
                    'scope' => 'global',
                    'filter' => array(
	                    'bool' => array(
		                    'must' => array(
			                    array(
				                    'terms' => array(
					                    'dataset' => array('dziennik_ustaw', 'monitor_polski'),
				                    ),
			                    ),
			                    array(
				                    'nested' => array(
					                    'path' => 'prawo-hasla',
					                    'filter' => array(
						                    'term' => array(
							                    'prawo-hasla.id' => $this->object->getId(),
						                    ),
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                    'aggs' => array(
	                    'ustawy' => array(
	                        'filter' => array(
		                        'or' => array(
			                        array(
				                        'term' => array(
			                                'data.dziennik_ustaw.typ_id' => '1',
			                            ),
			                        ),
			                        array(
				                        'term' => array(
			                                'data.monitor_polski.typ_id' => '1',
			                            ),
			                        ),
		                        ),
	                        ),
	                    ),
	                    'rozporzadzenia' => array(
	                        'filter' => array(
	                            'or' => array(
		                            array(
			                            'term' => array(
			                                'data.dziennik_ustaw.typ_id' => '3',
			                            ),
		                            ),
		                            array(
			                            'term' => array(
			                                'data.monitor_polski.typ_id' => '3',
			                            ),
		                            ),
	                            ),
	                        ),
	                    ),
	                    'inne' => array(
	                        'filter' => array(
	                            'bool' => array(
	                                'must_not' => array(
	                                    array(
		                                    'or' => array(
			                                    array(
				                                    'term' => array('data.dziennik_ustaw.typ_id' => '1')
			                                    ),
			                                    array(
				                                    'term' => array('data.monitor_polski.typ_id' => '1')
			                                    ),
		                                    ),
	                                    ),
	                                    array(
		                                    'or' => array(
			                                    array(
				                                    'term' => array('data.dziennik_ustaw.typ_id' => '3')
			                                    ),
			                                    array(
				                                    'term' => array('data.monitor_polski.typ_id' => '3')
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
        ));

        $this->set('title_for_layout', "Rozporządzenia dla tematu " . $this->object->getTitle());

    }
    
    public function inne()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => array('dziennik_ustaw', 'monitor_polski'),
                'dziennik_ustaw.typ_id!=' => array(1, 3),
                'monitor_polski.typ_id!=' => array(1, 3),
                'prawo-hasla:prawo-hasla.id' => $this->object->getId(),
            ),
            'aggs' => array(
                    
                'prawo' => array(
                    'scope' => 'global',
                    'filter' => array(
	                    'bool' => array(
		                    'must' => array(
			                    array(
				                    'terms' => array(
					                    'dataset' => array('dziennik_ustaw', 'monitor_polski'),
				                    ),
			                    ),
			                    array(
				                    'nested' => array(
					                    'path' => 'prawo-hasla',
					                    'filter' => array(
						                    'term' => array(
							                    'prawo-hasla.id' => $this->object->getId(),
						                    ),
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                    'aggs' => array(
	                    'ustawy' => array(
	                        'filter' => array(
		                        'or' => array(
			                        array(
				                        'term' => array(
			                                'data.dziennik_ustaw.typ_id' => '1',
			                            ),
			                        ),
			                        array(
				                        'term' => array(
			                                'data.monitor_polski.typ_id' => '1',
			                            ),
			                        ),
		                        ),
	                        ),
	                    ),
	                    'rozporzadzenia' => array(
	                        'filter' => array(
	                            'or' => array(
		                            array(
			                            'term' => array(
			                                'data.dziennik_ustaw.typ_id' => '3',
			                            ),
		                            ),
		                            array(
			                            'term' => array(
			                                'data.monitor_polski.typ_id' => '3',
			                            ),
		                            ),
	                            ),
	                        ),
	                    ),
	                    'inne' => array(
	                        'filter' => array(
	                            'bool' => array(
	                                'must_not' => array(
	                                    array(
		                                    'or' => array(
			                                    array(
				                                    'term' => array('data.dziennik_ustaw.typ_id' => '1')
			                                    ),
			                                    array(
				                                    'term' => array('data.monitor_polski.typ_id' => '1')
			                                    ),
		                                    ),
	                                    ),
	                                    array(
		                                    'or' => array(
			                                    array(
				                                    'term' => array('data.dziennik_ustaw.typ_id' => '3')
			                                    ),
			                                    array(
				                                    'term' => array('data.monitor_polski.typ_id' => '3')
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
        ));

        $this->set('title_for_layout', "Pozostałe akty prawne dla tematu " . $this->object->getTitle());

    }
    
    public function wszystkie()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => array('dziennik_ustaw', 'monitor_polski'),
                'prawo-hasla:prawo-hasla.id' => $this->object->getId(),
            ),
            'aggs' => array(
                    
                'prawo' => array(
                    'scope' => 'global',
                    'filter' => array(
	                    'bool' => array(
		                    'must' => array(
			                    array(
				                    'terms' => array(
					                    'dataset' => array('dziennik_ustaw', 'monitor_polski'),
				                    ),
			                    ),
			                    array(
				                    'nested' => array(
					                    'path' => 'prawo-hasla',
					                    'filter' => array(
						                    'term' => array(
							                    'prawo-hasla.id' => $this->object->getId(),
						                    ),
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
                    ),
                    'aggs' => array(
	                    'ustawy' => array(
	                        'filter' => array(
		                        'or' => array(
			                        array(
				                        'term' => array(
			                                'data.dziennik_ustaw.typ_id' => '1',
			                            ),
			                        ),
			                        array(
				                        'term' => array(
			                                'data.monitor_polski.typ_id' => '1',
			                            ),
			                        ),
		                        ),
	                        ),
	                    ),
	                    'rozporzadzenia' => array(
	                        'filter' => array(
	                            'or' => array(
		                            array(
			                            'term' => array(
			                                'data.dziennik_ustaw.typ_id' => '3',
			                            ),
		                            ),
		                            array(
			                            'term' => array(
			                                'data.monitor_polski.typ_id' => '3',
			                            ),
		                            ),
	                            ),
	                        ),
	                    ),
	                    'inne' => array(
	                        'filter' => array(
	                            'bool' => array(
	                                'must_not' => array(
	                                    array(
		                                    'or' => array(
			                                    array(
				                                    'term' => array('data.dziennik_ustaw.typ_id' => '1')
			                                    ),
			                                    array(
				                                    'term' => array('data.monitor_polski.typ_id' => '1')
			                                    ),
		                                    ),
	                                    ),
	                                    array(
		                                    'or' => array(
			                                    array(
				                                    'term' => array('data.dziennik_ustaw.typ_id' => '3')
			                                    ),
			                                    array(
				                                    'term' => array('data.monitor_polski.typ_id' => '3')
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
        ));

        $this->set('title_for_layout', "Wszystkie akty prawne dla tematu " . $this->object->getTitle());

    }
    
    public function beforeRender()
    {
	    	    
	    if( $this->hasUserRole('3') ) {
		    $this->addObjectEditable('prawo_hasla_merge');
		}
	    	    
	    parent::beforeRender();
	 	   
    } 

} 