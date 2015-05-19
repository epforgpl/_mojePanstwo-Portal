<?php

App::uses('DataobjectsController', 'Dane.Controller');

class InstytucjeController extends DataobjectsController
{
    public $dataFeedFilters = array(
        array('title' => 'Wszystko', 'icon' => 'all', 'link' => ''),
        array('title' => 'Odpowiedzi na interpelacje', 'icon' => 'interpelacje_odpowiedzi', 'link' => '#'),
        array('title' => 'Otrzymane interpelacje', 'icon' => 'interpelacje_otrzymane', 'link' => '#'),
        array('title' => 'Zamówienia publiczne', 'icon' => 'zamowienia_otrzymane', 'link' => '#'),
        array('title' => 'Zamówienia publiczne', 'icon' => 'zamowienia_otrzymane', 'link' => '#'),
        array('title' => 'Opublikowany tweet', 'icon' => 'twitter_opublikowane', 'link' => '#'),
    );

	public $loadChannels = true;
    public $initLayers = array('instytucja_nadrzedna', 'tree', 'menu', 'info');
	
	public function view()
    {
		
		$_layers = array('szef', 'channels', 'subscriptions');
        $this->addInitLayers($_layers);
                
        $this->_prepareView();
		
		$global_aggs = array(
			'prawo' => array(
		        'filter' => array(
			        'bool' => array(
				        'must' => array(
					        array(
						        'term' => array(
							        'dataset' => 'prawo',
						        ),
					        ),
					        array(
					        	'nested' => array(
						        	'path' => 'feeds_channels',	
						        	'filter' => array(
							        	'bool' => array(
								        	'must' => array(
									        	array(
											        'term' => array(
												        'feeds_channels.dataset' => 'instytucje',
											        ),
										        ),
										        array(
											        'term' => array(
												        'feeds_channels.object_id' => $this->request->params['id'],
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
		        'aggs' => array(
			        'top' => array(
				        'top_hits' => array(
					        'size' => 3,
					        'fielddata_fields' => array('dataset', 'id'),
					        'sort' => array(
						        'date' => array(
							        'order' => 'desc',
						        ),
					        ),
				        ),
			        ),
		        ),
	        ),
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
					        	'nested' => array(
						        	'path' => 'feeds_channels',	
						        	'filter' => array(
							        	'bool' => array(
								        	'must' => array(
									        	array(
											        'term' => array(
												        'feeds_channels.dataset' => 'instytucje',
											        ),
										        ),
										        array(
											        'term' => array(
												        'feeds_channels.object_id' => $this->request->params['id'],
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
		        'aggs' => array(
			        'top' => array(
				        'top_hits' => array(
					        'size' => 3,
					        'fielddata_fields' => array('dataset', 'id'),
					        'sort' => array(
						        'date' => 'desc',
					        ),
				        ),
			        ),
		        ),
	        ),
	        'dokumenty' => array(
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
						        'range' => array(
							        'date' => array(
								        'gt' => 'now-1y'
							        ),
						        ),
					        ),
					        array(
					        	'nested' => array(
						        	'path' => 'feeds_channels',	
						        	'filter' => array(
							        	'bool' => array(
								        	'must' => array(
									        	array(
											        'term' => array(
												        'feeds_channels.dataset' => 'instytucje',
											        ),
										        ),
										        array(
											        'term' => array(
												        'feeds_channels.object_id' => $this->request->params['id'],
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
		        'aggs' => array(
			        'wykonawcy' => array(
						'nested' => array(
							'path' => 'zamowienia_publiczne-wykonawcy',
						),
						'aggs' => array(
							'id' => array(								        
						        'terms' => array(
							        'field' => 'zamowienia_publiczne-wykonawcy.id',
							        'order' => array(
								        'cena' => 'desc',
							        ),
							        'size' => 3,
						        ),
						        'aggs' => array(
							        'nazwa' => array(
								        'terms' => array(
									        'field' => 'zamowienia_publiczne-wykonawcy.nazwa',
								        ),
							        ),
							        'miejscowosc' => array(
								        'terms' => array(
									        'field' => 'zamowienia_publiczne-wykonawcy.miejscowosc',
								        ),
							        ),
							        'cena' => array(
								        'sum' => array(
									        'field' => 'zamowienia_publiczne-wykonawcy.cena',
								        ),
							        ),
							        'dokumenty' => array(
								        'reverse_nested' => '_empty',
								        'aggs' => array(
									        'top' => array(
										        'top_hits' => array(
											        'size' => 3,
											        'fielddata_fields' => array('dataset', 'id'),
											        'sort' => array(
												        'zamowienia_publiczne-wykonawcy.cena' => 'desc',
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
		);
		
		
		$options  = array(
            'searchTitle' => 'Szukaj w ' . $this->object->getTitle() . '...',
            'conditions' => array(
	            '_object' => 'gminy.' . $this->object->getId(),
            ),
            'cover' => array(
	            'view' => array(
		            'plugin' => 'Dane',
		            'element' => 'instytucje/cover',
	            ),
	            'aggs' => array(
		            'all' => array(
				        'global' => '_empty',
				        'aggs' => $global_aggs,
			        ),
		        ),
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
		                'dictionary' => array(
			                'prawo_wojewodztwa' => array('prawo', 'Prawo lokalne'),
			                'zamowienia_publiczne' => array('zamowienia_publiczne', 'Zamówienia publiczne'),
		                ),
		            ),
		        ),
            ),
        );
                
	    $this->Components->load('Dane.DataBrowser', $options);
        
    }

    public function _prepareView()
    {

        if ($this->params->id == 903) {

            $this->addInitLayers(array('dzielnice'));
            $this->_layout['header']['element'] = 'pk';

        }

        if (
            defined('PORTAL_DOMAIN') &&
            defined('PK_DOMAIN') &&
            ($pieces = parse_url(Router::url($this->here, true))) &&
            ($pieces['host'] == PK_DOMAIN)
        ) {

            if ($this->params->id != 903) {

                $this->redirect('http://' . PORTAL_DOMAIN . $_SERVER['REQUEST_URI']);
                die();

            }

        }

        return parent::_prepareView();

    }

    public function instytucje()
    {

        parent::load();
        $this->request->params['action'] = 'instytucje';

    }

    public function prawo()
    {
        parent::load();
        $this->dataobjectsBrowserView(array(
            'source' => 'instytucje.prawo:' . $this->object->getId(),
            'dataset' => 'prawo',
            'noResultsTitle' => 'Brak aktów prawnych',
            'excludeFilters' => array(
                'autor_id',
            ),
            'title' => 'Akty prawne',
            'back' => $this->object->getUrl(),
            'backTitle' => $this->object->getTitle(),
        ));

        $this->set('title_for_layout', "Akty prawne wydane przez " . $this->object->getTitle());

    }

    public function tweety()
    {
        parent::load();
        $this->dataobjectsBrowserView(array(
            'source' => 'instytucje.twitter:' . $this->object->getId(),
            'dataset' => 'twitter',
            'noResultsTitle' => 'Brak tweetów',
            'title' => 'Tweety',
            'back' => $this->object->getUrl(),
            'backTitle' => $this->object->getTitle(),
            'excludeFilters' => array(
                'twitter_accounts.id', 'twitter_accounts.typ_id'
            ),
        ));

        $this->set('title_for_layout', "Tweety napisane przez " . $this->object->getTitle());

    }

    public function urzednicy()
    {
        parent::load();
        $this->dataobjectsBrowserView(array(
            // TODO wyswietlac tylko z tego urzedu
            'conditions' => array(
                'instytucja_id' => $this->object->getId()
            ),
            'dataset' => 'urzednicy',
            'noResultsTitle' => 'Brak informacji o urzędnikach',
            'title' => 'Urzędnicy',
            'back' => $this->object->getUrl(),
            'backTitle' => $this->object->getTitle(),
            'excludeFilters' => array(),
        ));

        $this->set('title_for_layout', "Urzędnicy pracujący w " . $this->object->getTitle());

    }

    public function zamowienia()
    {
        parent::load();
        $this->dataobjectsBrowserView(array(
            'source' => 'instytucje.zamowienia_udzielone:' . $this->object->getId(),
            'dataset' => 'zamowienia_publiczne',
            'noResultsTitle' => 'Brak zamówień',
            'title' => 'Zamówienia publiczne',
            'back' => $this->object->getUrl(),
            'backTitle' => $this->object->getTitle(),
            'hiddenFilters' => array('zamowienia_publiczne.zamawiajacy_id', 'zamowienia_publiczne.data_publikacji'),
            'excludeFilters' => array('zamowienia_publiczne.gmina_id'),
        ));

        $this->set('title_for_layout', "Zamówienia publiczne udzielone przez " . $this->object->getTitle());
    }

    public function budzet()
    {

        $this->addInitLayers(array('budzet'));

        parent::load();
        $this->set('title_for_layout', "Budżet " . $this->object->getTitle());

        $this->render('budzet');
    }

    public function beforeRender()
    {

        if ($this->object->getId() == 3214) {
            $this->headerObject = array('url' => '/dane/img/headers/sejmometr.jpg', 'height' => '250px');
        } else {
            $this->headerObject = array('url' => '/dane/img/headers/instytucje.jpg', 'height' => '250px');
        }
        

        $this->addons = array(
            'wniosek_udostepnienie' => array(
                'adresat_id' => $this->object->getDataset() . ':' . $this->object->getId(),
                'szablon_id' => 35,
                'nazwa' => 'Wyślij wniosek o udostępnienie informacji publicznej',
                'opis' => 'Masz pytania dotyczące działalności tej instytucji? Kliknij, aby wysłać odpowiedni wniosek.',
            )
        );

		if( $this->object->getData('email') ) {
		
	        $this->actions = array(
	            'pismo' => array(
	                'adresat_id' => $this->object->getDataset() . ':' . $this->object->getId(),
	                'szablon_id' => 35,
	                'nazwa' => 'Wyślij wniosek o udostępnienie informacji publicznej',
	                'opis' => 'Masz pytania dotyczące działalności tej instytucji? Kliknij, aby wysłać odpowiedni wniosek.',
	            ),
	        );
        
        }

        parent::beforeRender();
    }

} 