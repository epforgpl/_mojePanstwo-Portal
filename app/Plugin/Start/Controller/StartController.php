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
		return array();
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
