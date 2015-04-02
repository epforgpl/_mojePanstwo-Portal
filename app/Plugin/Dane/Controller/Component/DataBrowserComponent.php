<?php
class DataBrowserComponent extends Component {
	
	public $settings = array();
	public $conditions = array();
	public $order = array();
	private $Dataobject = false;
	private $aggs_visuals_map = array();
	
	private $aggs_presets = array(
		'gminy' => array(
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'gminy.typ_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Typy gmin',
		            'skin' => 'pie_chart',
	                'field' => 'gminy.typ_id',
	                'dictionary' => array(
		                '1' => 'Gmina miejska',
		                '2' => 'Gmina wiejska',
		                '3' => 'Gmina miejsko-wiejska',
		                '4' => 'Miasto stołeczne',
	                ),
	            ),
	        ),
	    ),
	    'powiaty' => array(
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'powiaty.typ_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Typy powiatów',
		            'skin' => 'pie_chart',
	                'field' => 'powiaty.typ_id',
	                'dictionary' => array(
		                '1' => 'Powiat',
		                '2' => 'Miasto na prawach powiatu',
		                '3' => 'Miasto stołeczne',
	                ),
	            ),
	        ),
	    ),
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
	    'twitter_accounts' => array(
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'twitter_accounts.typ_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Typy kont',
		            'skin' => 'pie_chart',
	                'field' => 'twitter_accounts.typ_id',
	                'dictionary' => array(
		                '1' => 'Posłowie',
		                '2' => 'Komentatorzy',
		                '3' => 'Urzędy',
		                '4' => 'Rząd',
		                '5' => 'Rzecznik prasowy',
		                '6' => 'Media',
		                '7' => 'Politycy',
		                '8' => 'Partia polityczna',
		                '9' => 'NGO',
	                ),
	            ),
	        ),
	    ),
	    'twitter' => array(
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'twitter_accounts.typ_id',
		            'exclude' => array(
			            'pattern' => '(0|)'
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Typy kont',
		            'skin' => 'pie_chart',
	                'field' => 'twitter_accounts.typ_id',
	                'dictionary' => array(
		                '1' => 'Posłowie',
		                '2' => 'Komentatorzy',
		                '3' => 'Urzędy',
		                '4' => 'Rząd',
		                '5' => 'Rzecznik prasowy',
		                '6' => 'Media',
		                '7' => 'Politycy',
		                '8' => 'Partia polityczna',
		                '9' => 'NGO',
	                ),
	            ),
	        ),
	        /*
	        'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba tweetów w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
	        */
	    ),
	    'rady_druki' => array(
		    'autor_id' => array(
	            'terms' => array(
		            'field' => 'rady_druki.autor_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.rady_druki.autor_str',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Autorzy projektów',
		            'skin' => 'pie_chart',
                    'field' => 'rady_druki.autor_id'
	            ),
	        ),
		    'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba druków w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
	    ),
	    'krakow_posiedzenia' => array(
		    'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba posiedzeń w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
	    ),
	    'prawo_lokalne' => array(
		    'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba uchwał w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
	    ),
	    'krakow_komisje_posiedzenia' => array(
		    'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba posiedzeń w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
	    ),
	    'radni_dzielnic' => array(
		    'dzielnice' => array(
	            'terms' => array(
		            'field' => 'radni_dzielnic.dzielnica_id',
		            'exclude' => array(
			            'pattern' => ''
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'dzielnice.nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Dzielnice',
		            'skin' => 'pie_chart',
                    'field' => 'radni_dzielnic.dzielnica_id'
	            ),
	        ),
	    ),
	    'krakow_dzielnice_uchwaly' => array(
		    'dzielnice' => array(
	            'terms' => array(
		            'field' => 'krakow_dzielnice_uchwaly.dzielnica_id',
		            'exclude' => array(
			            'pattern' => ''
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'dzielnice.nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Dzielnice',
		            'skin' => 'pie_chart',
                    'field' => 'krakow_dzielnice_uchwaly.dzielnica_id'
	            ),
	        ),
	    ),
	    'krakow_zarzadzenia' => array(
		    'realizacja' => array(
	            'terms' => array(
		            'field' => 'krakow_zarzadzenia.realizacja_str',
		            'exclude' => array(
			            'pattern' => ''
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'krakow_zarzadzenia.realizacja_str',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Statusy',
		            'skin' => 'pie_chart',
                    'field' => 'krakow_zarzadzenia.realizacja_str'
	            ),
	        ),
		    'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba zarządzeń w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
	        'status' => array(
	            'terms' => array(
		            'field' => 'krakow_zarzadzenia.status_str',
		            'exclude' => array(
			            'pattern' => ''
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'krakow_zarzadzenia.status_str',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Statusy',
		            'skin' => 'pie_chart',
                    'field' => 'krakow_zarzadzenia.status_str'
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
            ),
            'tryb_id' => array(
	            'terms' => array(
		            'field' => 'zamowienia_publiczne.tryb_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.zamowienia_publiczne_tryby.nazwa',
			            ),
		            ),
		            'wartosc_cena' => array(
			            'sum' => array(
		                    'field' => 'zamowienia_publiczne.wartosc_cena',
		                ),
	                ),
	            ),
	            'visual' => array(
		            'label' => 'Tryby zamówień',
		            'skin' => 'zamowienia_publiczne/pie_chart',
                    'field' => 'zamowienia_publiczne.tryb_id'
	            ),
	        ),
            'date' => array(
	            'date_histogram' => array(
		            'field' => 'date',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba zamówień publicznych w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'date'
	            ),
	        ),
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
	                    array('from' => 1, 'to' => 10000),
	                    array('from' => 10000, 'to' => 100000),
	                    array('from' => 100000, 'to' => 1000000),
	                    array('from' => 1000000, 'to' => 10000000),
	                    array('from' => 10000000),
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
	    'sejm_druki' => array(
	        'typ_id' => array(
	            'terms' => array(
		            'field' => 'sejm_druki.typ_id',
		            'exclude' => array(
			            'pattern' => '0'
		            ),
	            ),
	            'aggs' => array(
		            'label' => array(
			            'terms' => array(
				            'field' => 'data.sejm_druki.druk_typ_nazwa',
			            ),
		            ),
	            ),
	            'visual' => array(
		            'label' => 'Typy druków',
		            'skin' => 'pie_chart',
                    'field' => 'sejm_druki.typ_id'
	            ),
	        ),
	        'date' => array(
	            'date_histogram' => array(
		            'field' => 'sejm_druki.data',
		            'interval' => 'year',
		            'format' => 'yyyy-MM-dd',
	            ),
	            'visual' => array(
		            'label' => 'Liczba druków w czasie',
		            'skin' => 'date_histogram',
                    'field' => 'sejm_druki.data'
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
		    'api_call' => $controller->Dataobject->getDataSource()->public_api_call,
		    'renderFile' => isset( $this->settings['renderFile'] ) ? 'DataBrowser/templates/' . $this->settings['renderFile'] : 'default',
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