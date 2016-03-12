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
        );
        
        if( isset($this->request->query['q']) ) {
        	
        	$options['cover'] = array(
	        	'view' => array(
		        	'plugin' => 'Start',
		        	'element' => 'search',
	        	),
	        	'force' => true,
	        	'aggs' => array(),
        	);
        	
        	$options['perApps'] = true;
        	$options['browserTitle'] = 'Wyniki wyszukiwania w danych publicznych:';
	        $this->title = $this->request->query['q'] . ' | mojePaństwo';
        
        } else {
	        
	        $this->title = 'mojePaństwo';
	        
        }

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }

    public function getChapters()
    {
				
		if( 
			( $this->request->params['action'] == 'view' ) && 
			isset( $this->request->query['q'] )
		) {
			
			return array();
			
			
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
    
    public function beforeRender() {
	    
	    if( isset($this->request->query['q']) ) {
		    
		    $this->settings['id'] = 'dane';
		    $this->addBreadcrumb(array(
			    'label' => 'Wyniki wyszukiwania',
			    'href' => '/?q=' . $this->request->query['q'],
		    ));
		    		    
	    }
	    
	    parent::beforeRender();
	    
	    if( isset($this->request->query['q']) ) {
		    		    
		    if( $apps = @$this->viewVars['dataBrowser']['aggs']['apps']['buckets'] ) {
			    
			    foreach( $apps as &$a ) {
				    
			    	$a['app'] = $this->getApplication($a['key']);
			    	
			    	$path = (isset($a['app']['path']) && !empty($a['app']['path'])) ? $a['app']['path'] : $a['app']['id'];
                    $icon_link = '/' . $path . '/icon/icon_' . $a['app']['id'] . '.svg';
                    
                    $a['icon_path'] = $icon_link;
			    		
			    }
			    	
			    unset($this->viewVars['dataBrowser']['aggs']['apps']);
			    $this->set('apps', $apps);
			    
		    }
		    		    
	    }
	    
    }

}
