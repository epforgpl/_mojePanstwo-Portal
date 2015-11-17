<?php

App::uses('DataobjectsController', 'Dane.Controller');

class NgoTematyController extends DataobjectsController
{

    public $observeOptions = true;

    public $helpers = array(
        'Time', 'Czas'
    );
    public $components = array('RequestHandler', 'Media.Twitter');
    public $objectOptions = array(
        'hlFields' => array(),
        'bigTitle' => true,
    );

    public $loadChannels = true;
    
    public $objectActivities = true;
    public $objectData = true;
    public $objectCollections = true;
	public $addDatasetBreadcrumb = false;
	
	public $submenus = array(
        'dzialania' => array(
            'items' => array(
                array(
                    'id' => 'dzialania',
                    'label' => 'Kampanie społeczne',
                ),
                array(
                    'id' => 'inicjatywy',
                    'label' => 'Inicjatywy pomocowe',
                ),
                array(
                    'id' => 'osrodki',
                    'label' => 'W ośrodkach',
                ),
            ),
        ),
    );
    
    public function view()
    {

        $this->_prepareView();

    }
    
    public function informacje()
    {

        $this->_prepareView();

    }
    
    public function dzialania()
    {

        $this->_prepareView();
        
        $options = array(
            'searchTitle' => 'Szukaj działań...',
            'conditions' => array(
                'dataset' => 'dzialania',
                'dzialania.status' => '1',
                'dzialania.id!=' => '125',
            ),
            // 'aggsPreset' => 'radni_gmin',
            'paginatorPhrases' => array('działanie', 'działania', 'działań'),
        );

        $this->set('_submenu', array_merge($this->submenus['dzialania'], array(
            'selected' => 'dzialania',
        )));

        $this->Components->load('Dane.DataBrowser', $options);
        $this->set('title_for_layout', 'Działania na rzecz uchodźców');

    }
    
    public function organizacje()
    {

        $this->_prepareView();
        
        $options = array(
            'searchTitle' => 'Szukaj organizacji...',
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.forma_prawna_id' => '1',
            ),
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->set('title_for_layout', 'Organizacje działające na rzecz uchodźców');

    }

    public function getMenu()
    {
        if(!$this->object)
            return false;

        $counters = $this->object->getLayers('counters');

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Podstawowe dane',
                    'icon' => array(
                        'src' => 'glyphicon',
                        'id' => 'home',
                    ),
                ),
            ),
            'base' => $this->object->getUrl(),
        );

        $menu['items'][] = array(
            'id' => 'informacje',
            'label' => 'Informacje',
        );
        
        $menu['items'][] = array(
            'id' => 'dzialania',
            'label' => 'Działania',
        );
        
        $menu['items'][] = array(
            'id' => 'organizacje',
            'label' => 'Organizacje',
        );
        
        $menu['items'][] = array(
            'id' => 'materiały',
            'label' => 'Materiały',
        );
        
        $menu['items'][] = array(
            'id' => 'pomoc',
            'label' => 'Jak pomagać?',
        );
		
		$menu['items'][] = array(
            'id' => 'kontakt',
            'label' => 'Kontakt',
        );

        return $menu;
    }

}
