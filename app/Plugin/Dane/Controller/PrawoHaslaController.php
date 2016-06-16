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
			                    /*
			                    'should' => array(
				                    array(
					                    'multi_match' => array(
							        		'query' => mb_convert_encoding($this->object->getData('q'), 'UTF-8', 'UTF-8'),
								        	'fields' => array('title', 'text', 'acronym'),
								        	// 'cutoff_frequency' => 0.001,
										    'type' => "phrase",
											'slop' => 5,
						        		),
				                    ),
			                    ),
			                    */
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

        $menu['items'][] = array(
            'id' => 'akty',
            'label' => 'Powiązane akty prawne',
        );

        return $menu;

    }

    public function akty()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo',
                'prawo.haslo_id' => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', "Akty prawne dla tematu " . $this->object->getTitle());

    }
    
    public function beforeRender()
    {
	    
	    if( $this->hasUserRole('3') ) {
		    $this->addObjectEditable('prawo_hasla_merge');
		}
	    	    
	    parent::beforeRender();
	 	   
    } 

} 