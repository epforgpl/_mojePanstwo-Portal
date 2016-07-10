<?php

App::uses('DataobjectsController', 'Dane.Controller');

class ZamowieniaPubliczneZamawiajacyController extends DataobjectsController
{
    public $menu = array();
    public $initLayers = array();
	
	public function load() {
				
		if( $this->request->params['action'] != 'view' ) {
			
			$this->addInitAggs(array(
	            'all' => array(
	                'global' => '_empty',
	                'aggs' => array(
	                    'zamowienia' => array(
			                'filter' => array(
			                    'bool' => array(
			                        'must' => array(
			                            array(
			                                'term' => array(
			                                    'dataset' => 'zamowienia_publiczne',
			                                ),
			                            ),
			                            array(
			                                'term' => array(
			                                    'data.zamowienia_publiczne.zamawiajacy_id' => $this->request->params['id'],
			                                ),
			                            ),
			                        ),
			                    ),
			                ),
			            ),
	                ),
	            ),
	        ));
			
		}
		
		parent::load();
				
		if( $this->object->getData('dataset') && $this->object->getData('object_id') )
			return $this->redirect('/dane/' . $this->object->getData('dataset') . '/' . $this->object->getData('object_id'));
		
	}
	
    public function view()
    {
		
		return $this->redirect('/zamowienia_publiczne/zamowienia?conditions[zamowienia_publiczne.zamawiajacy_id]=' . $this->request->params['id']);
		
        $this->load();
        
        $global_aggs = array(
            'zamowienia' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne.zamawiajacy_id' => $this->object->getId(),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'zamowienia_publiczne_dokumenty' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne_dokumenty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne_dokumenty.zamawiajacy_id' => $this->object->getId(),
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne_dokumenty.typ_id' => '3',
                                ),
                            ),
                            array(
                                'range' => array(
                                    'date' => array(
                                        'gt' => 'now-1y'
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'dni' => array(
						'date_histogram' => array(
							'field' => 'date',
							'interval' => 'day',
						),
						'aggs' => array(
							'wykonawcy' => array(
								'nested' => array(
									'path' => 'zamowienia_publiczne-wykonawcy',
								),
								'aggs' => array(
									'waluty' => array(
										'terms' => array(
											'field' => 'zamowienia_publiczne-wykonawcy.waluta',
										),
										'aggs' => array(
											'suma' => array(
												'sum' => array(
													'field' => 'zamowienia_publiczne-wykonawcy.cena',
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
        
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne',
                'zamowienia_publiczne.zamawiajacy_id' => $this->object->getId(),
            ),
            'searchTitle' => 'Szukaj w zamówieniach publicznych...',
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'zamowienia_publiczne_zamawiajacy/cover',
                ),
                'aggs' => $global_aggs,
            ),
        ));
        $this->render('Dane.DataBrowser/browser');

    }
    
    public function getMenu()
    {

        if( !$this->object )
        	return false;
			
		$aggs = array();
		if( isset($this->viewVars['dataBrowser']['aggs']['all']) )
			$aggs = $this->viewVars['dataBrowser']['aggs']['all'];
			
		if( isset($this->object_aggs['all']) )
			$aggs = $this->object_aggs['all'];
					
        $menu = array(
            'items' => array(),
            'base' => $this->object->getUrl(),
        );

        $menu['items'][] = array(
            'label' => 'Aktualności',
            'icon' => array(
	            'src' => 'glyphicon',
	            'id' => 'home',
            ),
        );

		if( isset($aggs['zamowienia']) && $aggs['zamowienia']['doc_count'] ) {
	        $menu['items'][] = array(
	            'label' => 'Zamówienia publiczne',
	            'id' => 'zamowienia',
	            'count' => $aggs['zamowienia']['doc_count'],
	        );
        }

        return $menu;

    }
    
    public function zamowienia()
    {

        $this->load();
        
        $global_aggs = array(
            'zamowienia_publiczne_dokumenty' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne_dokumenty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne_dokumenty.typ_id' => '3',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne_dokumenty.zamawiajacy_id' => $this->object->getId(),
                                ),
                            ),
                            array(
                                'range' => array(
                                    'date' => array(
                                        'gt' => 'now-3y'
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'dni' => array(
						'date_histogram' => array(
							'field' => 'date',
							'interval' => 'day',
						),
						'aggs' => array(
							'wykonawcy' => array(
								'nested' => array(
									'path' => 'zamowienia_publiczne-wykonawcy',
								),
								'aggs' => array(
									'waluty' => array(
										'terms' => array(
											'field' => 'zamowienia_publiczne-wykonawcy.waluta',
										),
										'aggs' => array(
											'suma' => array(
												'sum' => array(
													'field' => 'zamowienia_publiczne-wykonawcy.cena',
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


        $options = array(
            'searchTitle' => 'Szukaj w zamówieniach publicznych...',
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne',
                'zamowienia_publiczne.zamawiajacy_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'zamowienia_publiczne',
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'zamowienia_publiczne_zamawiajacy/zamowienia-cover',
                ),
                'aggs' => array(
                    'all' => array(
                        'global' => '_empty',
                        'aggs' => $global_aggs,
                    ),
                ),
            ),
        );

        $this->Components->load('Dane.DataBrowser', $options);

        $this->set('title_for_layout', "Zamówienia publiczne udzielone przez " . $this->object->getTitle());
    }

    public function zamowienia_rozstrzygniete()
    {

        $this->load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne_dokumenty',
                'zamowienia_publiczne_dokumenty.typ_id' => '3',
                'zamowienia_publiczne_dokumenty.zamawiajacy_id' => $this->object->getId(),                
            ),
            'renderFile' => 'zamowienia_publiczne_dokumenty',
            'aggsPreset' => 'zamowienia_publiczne_dokumenty',
        ));
		
		$this->menu_selected = 'zamowienia';
		$this->set('DataBrowserTitle', 'Rozstrzygnięcia zamówień publicznych');
        $this->set('title_for_layout', "Rozstrzygnięte zamówienia publiczne dla " . $this->object->getTitle());
        
        $this->menu['selected'] = 'zamowienia';
    }
} 