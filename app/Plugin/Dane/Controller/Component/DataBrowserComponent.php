<?php
class DataBrowserComponent extends Component {
	
	public $settings = array();
	public $conditions = array();
	public $order = array();
	private $Dataobject = false;
	private $aggs_visuals_map = array();
	
	private $aggs_presets = array(
		'miejscowosci' => array(
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'miejscowosci.typ_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'miejscowosci_typy.nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Typy miejscowości',
		            'skin' => 'pie_chart',
                    'field' => 'miejscowosci.typ_id'
	            ),
	        ),
	    ),
		'prawo' => array(
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'prawo.typ_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.prawo.typ_nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Typy aktów prawnych',
		            'skin' => 'pie_chart',
                    'field' => 'prawo.typ_id'
	            ),
	        ),
	        'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba aktów prawnych w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
	        'autor_id' => array(
	            'terms' => array(
		            'field' => 'prawo.autor_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.prawo.autor_nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Autorzy aktów prawnych',
		            'skin' => 'columns_horizontal',
                    'field' => 'prawo.autor_id'
	            ),
	        ),
	    ),
	    'prawo_urzedowe' => array(
	        /*
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'prawo.typ_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.prawo.typ_nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Typy aktów prawnych',
		            'skin' => 'pie_chart',
	            ),
	        ),
	        */
	        'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba aktów prawnych w czasie',
		            'skin' => 'date_histogram',
	            ),
	        ),
	        /*
	        'autor_id' => array(
	            'terms' => array(
		            'field' => 'prawo.autor_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.prawo.autor_nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Autorzy aktów prawnych',
		            'skin' => 'columns_horizontal',
	            ),
	        ),
	        */
	    ),
        'zamowienia_publiczne' => array(
            'wartosc_cena' => array(
                'sum' => array(
                    'field' => 'zamowienia_publiczne.wartosc_cena',
                ),
                'visual' => array(
                    'label' => 'Wartość zamówień',
                    'skin' => 'numeric',
                    'field' => 'zamowienia_publiczne.wartosc_cena',
                    'currency' => 'pln'
                ),
            )
        ),
        'krs_osoby' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'krs_osoby.plec',
                    'include' => array(
                        'pattern' => '(K|M)'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krs_osoby.plec',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Płeć',
                    'skin' => 'pie_chart',
                    'field' => 'krs_osoby.plec',
                )
            )
        ),
	    'krs_podmioty' => array(
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'krs_podmioty.forma_prawna_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.krs_podmioty.forma_prawna_str',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Formy prawne organizacji',
		            'skin' => 'pie_chart',
		            'field' => 'krs_podmioty.forma_prawna_id',
	            ),
	        ),
	        'kapitalizacja' => array(
		        'range' => array(
	                'field' => 'krs_podmioty.wartosc_kapital_zakladowy',
	                'ranges' => array(
	                    array('from' => 1, 'to' => 5000),
	                    array('from' => 5000, 'to' => 50000),
	                    array('from' => 50000, 'to' => 500000),
	                    array('from' => 500000, 'to' => 5000000),
	                    array('from' => 5000000, 'to' => 50000000),
	                    array('from' => 50000000)
                    ),
                ),
                'visual' => array(
		            'label' => 'Kapitalizacja spółek',
		            'skin' => 'krs/kapitalizacja',
		            'field' => 'krs_podmioty.wartosc_kapital_zakladowy',
	            ),
	        ),
	        'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Nowe organizacje w czasie',
		            'skin' => 'date_histogram',
		            'field' => 'date',
	            ),
	        ),
	        /*
	        'autor_id' => array(
	            'terms' => array(
		            'field' => 'prawo.autor_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.prawo.autor_nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Autorzy aktów prawnych',
		            'skin' => 'columns_horizontal',
	            ),
	        ),
	        */
	    ),
	    'dotacje_ue' => array(
	        'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba udzielonych dotacji w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
	    ),
	);
	
	public function __construct($collection, $settings) {
				
		if( 
			(
				!isset( $settings['aggs'] ) || 
				( empty($settings['aggs']) ) 
			) &&  
			isset( $settings['aggsPreset'] ) && 
			array_key_exists($settings['aggsPreset'],  $this->aggs_presets) 
		)
			$settings['aggs'] = $this->aggs_presets[ $settings['aggsPreset'] ];
		
		
		if( isset($settings['aggs']) ) {
	        foreach($settings['aggs'] as $key => $value) {
	            foreach($value as $keyM => $valueM) {
	                if($keyM === 'visual') {
	                    $this->aggs_visuals_map[$key] = $valueM;
	                    unset($settings['aggs'][$key][$keyM]);
	                }
	            }
	        }
        }

		$this->settings = $settings;
		
	}

    private function getCancelSearchUrl($controller) {
        if(!isset($controller->request->query) || count($controller->request->query) === 0)
            return $controller->here;

        $query = $controller->request->query;

        if(isset($query['q']))
            unset($query['q']);

        if(isset($query['page']))
            unset($query['page']);

        if(isset($query['conditions']['q']))
            unset($query['conditions']['q']);

        if(
        	count(@array_count_values($query)) || 
        	(
	        	isset($query['conditions']) && 
        		count($query['conditions'])
        	)
        )
            $query = '?' . http_build_query($query);
        else
            $query = '';

        return $controller->here . $query;
    }

    private function prepareRequests($maps, $controller) {
        $query = $controller->request->query;

        foreach($maps as $i => $map) {
            // Anulowanie np. wybranego typu
            $cancelQuery = $query;
            if(isset($cancelQuery['conditions'][$map['field']]))
                unset($cancelQuery['conditions'][$map['field']]);
            if(isset($cancelQuery['page']))
                unset($cancelQuery['page']);
            if(isset($cancelQuery['conditions']['q']))
                unset($cancelQuery['conditions']['q']);
            $maps[$i]['cancelRequest'] = $controller->here . '?' . http_build_query($cancelQuery);

            // Wybieranie np. danego typu
            // Nie znamy jeszcze id dlatego na końcu zostawiamy `=` np.
            // http://.../?..&conditions[type.id]=
            $chooseQuery = $query;
            if(isset($cancelQuery['page']))
                unset($cancelQuery['page']);
            $maps[$i]['chooseRequest'] =
                $controller->here . '?' . http_build_query($cancelQuery) .
                '&conditions[' . $map['field'] . ']=';
        }

        return $maps;
    }
	
	public function beforeRender($controller){
		
		$controller->helpers[] = 'Dane.Dataobject';
		
		if( is_null($controller->Paginator) ) {
			$controller->Paginator = $controller->Components->load('Paginator');
		}
		
		if( isset( $controller->request->query['q'] ) ) {
			$controller->request->query['conditions']['q'] = $controller->request->query['q'];
		}
			
		$this->queryData = $controller->request->query;

		if( !property_exists($controller, 'Dataobject') )
			$controller->Dataobject = ClassRegistry::init('Dane.Dataobject');
		
		$controller->Paginator->settings = $this->getSettings();
		// $controller->Paginator->settings['order'] = 'score desc';
		// debug($controller->Paginator->settings); die();	
		$hits = $controller->Paginator->paginate('Dataobject');

	    $controller->set('dataBrowser', array(
		    'hits' => $hits,
		    'took' => $controller->Dataobject->getPerformance(),
		    'aggs' => $controller->Dataobject->getAggs(),
            'aggs_visuals_map' => $this->prepareRequests($this->aggs_visuals_map, $controller),
		    'cancel_url' => $this->getCancelSearchUrl($controller),
	    ));
		
	}
	
	
	private function getSettings() {
		
		$conditions = $this->getSettingsForField('conditions');
		
		$output = array(
			'paramType' => 'querystring',
			'conditions' => $conditions,
			'aggs' => $this->getSettingsForField('aggs'),
			'order' => $this->getSettingsForField('order'),
			'limit' => isset($this->settings['limit']) ? $this->settings['limit'] : 50,
		);
						
		if( isset($conditions['q']) )
			$output['highlight'] = true;
		
		return $output;
		
	}
	
	private function getSettingsForField($field) {
		
		$params = isset( $this->queryData[$field] ) ? $this->queryData[$field] : array();
				
		if( isset($this->settings[$field]) ) {
			if( is_array($this->settings[$field]) )
				$params = array_merge($params, $this->settings[$field]);
			else
				$params = $this->settings[$field];
		}
		
		return $params;
		
	}
	
}