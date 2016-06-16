<?php

App::uses('ApplicationsController', 'Controller');

class PrawoController extends ApplicationsController
{

    public $settings = array(
        'id' => 'prawo',
        'title' => 'Prawo',
        'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce',
        'headerImg' => 'prawo',
    );
    public $mainMenuLabel = 'Przeglądaj';
	
	public $menu = array(
		'sejm_komunikaty' => array(
			'id' => 'aktualnosci',
			'label' => 'Aktualności',
			'icon' => 'icon-datasets-sejm_komunikaty',
			'href' => '/prawo/aktualnosci',
		),
		'prawo_hasla' => array(
			'id' => 'tematy',
			'label' => 'Tematy',
			'icon' => 'icon-datasets-prawo_hasla',
			'href' => '/prawo/tematy',
		),
		'dziennik_ustaw' => array(
			'id' => 'dziennik_ustaw',
			'label' => 'Dziennik Ustaw',
			'icon' => 'icon-datasets-prawo',
			'href' => '/prawo/dziennik_ustaw',
		),
		'monitor_polski' => array(
			'id' => 'monitor_polski',
			'label' => 'Monitor Polski',
			'icon' => 'icon-datasets-prawo',
			'href' => '/prawo/monitor_polski',
		),
		'prawo_wojewodztwa' => array(
			'id' => 'lokalne',
			'label' => 'Prawo lokalne',
			'icon' => 'icon-datasets-prawo',
			'href' => '/prawo/lokalne',
		),
		'prawo_urzedowe' => array(
			'id' => 'urzedowe',
			'label' => 'Prawo urzędowe',
			'icon' => 'icon-datasets-prawo',
			'href' => '/prawo/urzedowe',
		),
	);
	
	public $_aggs = array(
        'dataset' => array(
            'terms' => array(
                'field' => 'dataset',
            ),
            'aggs' => array(
                'typ' => array(
                    'terms' => array(
	                    'field' => 'data.prawo.typ_id',
	                    'size' => 100,
                    ),
                ),
                'publikator' => array(
	                'terms' => array(
		                'field' => 'data.prawo.zrodlo',
		                'size' => 100,
	                ),
                ),
            ),
        ),
    );
	
	private function getSubAggs() {
	    return array(
	        '_query' => array(
	            'filter' => array(
		            'or' => array(
			            array(
				            'terms' => array(
					            'dataset' => array('prawo', 'prawo_hasla', 'prawo_wojewodztwa', 'prawo_urzedowe'),
				            ),
			            ),
			            array(
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
	            ),
	            'scope' => 'query',
	            'aggs' => $this->_aggs,
	        ),
	    );
    }
	
    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function view()
    {

        $datasets = $this->getDatasets('prawo');
        $_datasets = array_keys($datasets);
        
        $options = array(
            'searchTag' => array(
	            'href' => '/prawo',
	            'label' => 'Prawo',
            ),
            'autocompletion' => array(
                'dataset' => 'prawo,prawo_hasla',
            ),
            'conditions' => array(
                'dataset' => array(
	                'dziennik_ustaw',
	                'monitor_polski',
	                'prawo_hasla',
	                'prawo_wojewodztwa',
	                'prawo_urzedowe',
	                'sejm_komunikaty{sejm_komunikaty.typ_id:0}'
                ),
            ),
            'aggs' => $this->_aggs,
            'cover' => array(
                'cache' => true,
                'view' => array(
                    'plugin' => 'Prawo',
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
				                    'size' => 10,
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
						                    'dataset' => 'dziennik_ustaw',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.dziennik_ustaw.konstytucja' => '1',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.dziennik_ustaw.status_id' => '1',
					                    ),
				                    ),
			                    ),
		                    ),
	                    ),
	                    'scope' => 'global',
	                    'aggs' => array(
		                    'top' => array(
			                    'top_hits' => array(
				                    'size' => 1,
				                    'fielddata_fields' => array('dataset', 'id'),
				                    'sort' => array(
					                    'date' => 'desc',
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
						                    'dataset' => 'dziennik_ustaw',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.dziennik_ustaw.kodeks' => '1',
					                    ),
				                    ),
				                    array(
					                    'term' => array(
						                    'data.dziennik_ustaw.status_id' => '1',
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
            'perDatasets' => true,
            'appObserve' => 2,
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }
    	
	public function aktualnosci()
    {
 	    $this->title = 'Aktualności prawne';
        $this->loadDatasetBrowser('sejm_komunikaty', array(
            'browserTitle' => 'Aktualności',
            'conditions' => array(
                'dataset' => 'sejm_komunikaty',
                'sejm_komunikaty.typ_id' => '0',
            ),
            'aggs' => $this->getSubAggs(),
        ));
    }
    

    public function lokalne()
    {
	    $this->title = 'Prawo lokalne';
        $this->loadDatasetBrowser('prawo_wojewodztwa', array(
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function urzedowe()
    {
	    $this->title = 'Prawo urzędowe';
        $this->loadDatasetBrowser('prawo_urzedowe', array(
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function tematy()
    {
	    $this->title = 'Prawo urzędowe';
        $this->loadDatasetBrowser('prawo_hasla', array(
            'aggs' => $this->getSubAggs(),
        ));
    }
    
    public function ustawy()
    {
        return $this->redirect('/prawo/dziennik_ustaw?&conditions[dziennik_ustaw.typ_id]=1');
    }
    
    public function dziennik_ustaw()
    {
        $this->title = 'Dziennik Ustaw';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.zrodlo' => 'DzU',
            ),
            'aggs' => $this->getSubAggs(),
            'sortPreset' => 'prawo',
            'phrasesPreset' => 'akty_prawne',
        ));
    }
    
    public function monitor_polski()
    {
        $this->title = 'Monitor Polski';
        $this->loadDatasetBrowser('prawo', array(
            'conditions' => array(
                'prawo.zrodlo' => 'MP',
            ),
            'aggs' => $this->getSubAggs(),
            'sortPreset' => 'prawo',
            'phrasesPreset' => 'akty_prawne',
        ));
    }
            
    public function rozporzadzenia()
    {
        return $this->redirect('/prawo/dziennik_ustaw?&conditions[dziennik_ustaw.typ_id]=3');
    }
    
    public function umowy()
    {
        return $this->redirect('/prawo/dziennik_ustaw?&conditions[dziennik_ustaw.typ_id]=6');
    }
	
	public function inne()
    {
        return $this->redirect('/prawo/dziennik_ustaw?&conditions[dziennik_ustaw.typ_id]=0');
    }
    
    public function powszechne() {
        return $this->redirect('/prawo/dziennik_ustaw');
    }
	
} 