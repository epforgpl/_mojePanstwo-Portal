<?php

App::uses('ApplicationsController', 'Controller');

class StartController extends ApplicationsController
{

	public $settings = array(
        'id' => '',
        'title' => 'mojePaństwo',
        'shortTitle' => 'mojePaństwo',
        'subtitle' => '',
    );

	public function help() {

	}

	public function view()
    {

        $options = array(
            'searchTag' => array(
	            'href' => '/krs',
	            'label' => 'KRS',
            ),
            'autocompletion' => array(
                'dataset' => 'krs_podmioty,krs_osoby',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Start',
                    'element' => 'cover',
                ),
                'aggs' => array(
                ),
            ),
            'apps' => true,
            'browserTitle' => 'Wyniki wyszukiwania:',
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->title = 'mojePaństwo';
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }

    public function getChapters()
    {
				
		if( 
			( $this->request->params['action'] == 'view' ) && 
			isset( $this->request->query['q'] )
		) {
			
			$items = array();

			if( @$this->viewVars['dataBrowser']['aggs'] ) {
				
				$items[] = array(
					'id' => 'search',
					'icon' => 'icon-search',
					'label' => 'Szukaj w aplikacjach:',
				);
				
				foreach( @$this->viewVars['dataBrowser']['aggs'] as $k => $v ) {
					if( 
						( strpos($k, 'app_')===0 ) && 
						@$v['doc_count']
					) {
						
						$app_id = substr($k, 4);
						$app = $this->getApplication( $app_id );
												
						$items[] = array(
							'id' => $app_id,
							'label' => $app['name'],
							'icon' => 'icon-application icon-applications-' . $app_id,
							'count' => $v['doc_count'],
							'href' => $app['href'] . '?q=' . urlencode( $this->request->query['q'] ),
						);
					
					}
				}
			}
			
			return array(
				'items' => $items,
				'selected' => 'search',
			);
			
			
		} else {

			$items = array(
				array(
					'id' => 'powiadomienia',
					'label' => 'Moje powiadomienia',
					'icon' => 'icon-applications-powiadomienia',
					'href' => 'moje-powiadomienia',
				),
				array(
					'id' => 'pisma',
					'label' => 'Moje pisma',
					'icon' => 'icon-datasets-pisma',
					'href' => 'moje-pisma',
				),
				array(
					'id' => 'kolekcje',
					'label' => 'Moje kolekcje',
					'icon' => 'icon-datasets-kolekcje',
					'href' => 'moje-kolekcje',
				),
				array(
					'id' => 'konto',
					'label' => 'Ustawienia konta',
					'icon' => 'icon-datasets-users',
					'href' => 'konto',
				),
				array(
					'id' => 'strony',
					'label' => 'Strony, którymi zarządzam',
					'icon' => 'icon-datasets-strony',
					'href' => 'moje-strony',
				),
			);

			if($this->hasUserRole('2')) {
				$items[] = array(
					'id' => 'admin',
					'label' => 'Panel administratora',
					'icon' => 'icon-datasets-strony',
					'href' => 'admin',
				);
			}
		
	        return array(
			    'items' => $items
		    );
	    
	    }

    }

}
