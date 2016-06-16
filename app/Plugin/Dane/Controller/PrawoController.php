<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PrawoController extends DataobjectsController
{

    public $initLayers = array('docs', 'counters', 'files');
    public $helpers = array('Document');
	public $addDatasetBreadcrumb = false;
    public $observeOptions = true;

    public $headerObject = array('url' => '/dane/img/headers/ustawa.jpg', 'height' => '250px');

    public $objectOptions = array(
        'hlFields' => array(),
        'routes' => array(
            'description' => false,
        ),
    );
    
    public function _prepareView()
    {
	            
        parent::_prepareView();
        
        $dataset = false;
        if( $this->object->getData('zrodlo') == 'DzU' )
        	$dataset = 'dziennik_ustaw';
        elseif( $this->object->getData('zrodlo') == 'MP' )
        	$dataset = 'monitor_polski';
        
        if( $dataset ) {
	        
	        $url = '/dane/' . $dataset . '/' . $this->object->getId() . ',' . $this->object->getSlug();
	        if( $this->request->params['action'] != 'view' )
	        	$url .= '/' . $this->request->params['action'];
	        
        } else {
	        
	        $url = '/';
	        
        }
                        
        return $this->redirect($url);
	    
    }
    
    public function view()
    {
        $this->_prepareView();
    }
    
    public function hasla()
    {
        $this->_prepareView();
    }

    private function connections_view($id, $title)
    {
		
		$this->_prepareView();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo',
                'prawo.' . $id => $this->object->getId(),
            ),
            'browserTitle' => $title . ':',
        ));
		
        $this->set('title_for_layout', $title . ': ' . $this->object->getTitle());

    }
	
	public function podstawa_prawna()
    {
        return $this->connections_view('podstawa_prawna', 'Podstawy prawne do tego aktu');
    }
	
    public function podstawa_prawna_z_artykulem()
    {
        return $this->connections_view('podstawa_prawna_z_artykulem', 'Podstawy prawne z artykułem do tego aktu');
    }

    public function akty_zmienione()
    {
        return $this->connections_view('akty_zmienione', 'Akty zmienione przez ten akt');
    }

    public function akty_wykonawcze()
    {
        return $this->connections_view('akty_wykonawcze', 'Akty wykonawcze wydane do tego aktu');
    }

    public function akty_uchylone()
    {
        return $this->connections_view('akty_uchylone', 'Akty uchylone przez ten akt');
    }

    public function akty_uznane_za_uchylone()
    {
        return $this->connections_view('akty_uznane_za_uchylone', 'Akty uznane za uchylone przez ten akt');
    }

    public function orzeczenie_do_aktu()
    {
        return $this->connections_view('orzeczenie_do_aktu', 'Orzeczenia do tego aktu');
    }

    public function tekst_jednolity_do_aktu()
    {
        return $this->connections_view('tekst_jednolity_do_aktu', 'Teksty jednolite tego aktu');
    }

    public function orzeczenia_tk()
    {
        return $this->connections_view('orzeczenie_tk', 'Orzeczenia Trybunału Konstytucyjnego do tego aktu');
    }

    public function informacja_o_tekscie_jednolitym()
    {
        return $this->connections_view('informacja_o_tekscie_jednolitym', 'Informacje o tekście jednolitym tego aktu');
    }

    public function akty_zmieniajace()
    {
        return $this->connections_view('akty_zmieniajace', 'Nowelizacje tego aktu');
    }

    public function akty_uchylajace()
    {
        return $this->connections_view('akty_uchylajace', 'Akty uchylające ten akt');
    }

    public function uchylenia_wynikajace_z()
    {
        return $this->connections_view('uchylenia_wynikajace_z', 'Uchylenia wynikające z tego aktu');
    }

    public function dyrektywy_europejskie()
    {
        return $this->connections_view('dyrektywy_europejskie', 'Dyrektywy europejskie');
    }

    public function odeslania()
    {
        return $this->connections_view('odeslania', 'Odesłania zawarte w tym akcie');
    }

	public function getMenu()
	{
		
		$menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Treść',
                ),
            ),
            'base' => $this->object->getUrl(),
        );
        

        
        if( @$this->object_aggs['prawo']['akty_uchylajace']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'akty_uchylajace',
	        	'label' => 'Akty uchylające',
	        	'count' => $this->object_aggs['prawo']['akty_uchylajace']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['akty_uchylone']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'akty_uchylone',
	        	'label' => 'Akty uchylone',
	        	'count' => $this->object_aggs['prawo']['akty_uchylone']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['akty_wykonawcze']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'akty_wykonawcze',
	        	'label' => 'Akty wykonawcze',
	        	'count' => $this->object_aggs['prawo']['akty_wykonawcze']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['akty_uznane_za_uchylone']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'akty_uznane_za_uchylone',
	        	'label' => 'Akty uznane za uchylone',
	        	'count' => $this->object_aggs['prawo']['akty_uznane_za_uchylone']['doc_count'],
        	);
                
        if( @$this->object_aggs['prawo']['akty_zmieniajace']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'akty_zmieniajace',
	        	'label' => 'Nowelizacje',
	        	'count' => $this->object_aggs['prawo']['akty_zmieniajace']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['akty_zmienione']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'akty_zmienione',
	        	'label' => 'Akty zmienione',
	        	'count' => $this->object_aggs['prawo']['akty_zmienione']['doc_count'],
        	);
        
        if( @$this->object_aggs['prawo']['informacja_o_tekscie_jednolitym']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'informacja_o_tekscie_jednolitym',
	        	'label' => 'Informacja o tekście jednolitym',
	        	'count' => $this->object_aggs['prawo']['informacja_o_tekscie_jednolitym']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['odeslania']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'odeslania',
	        	'label' => 'Odesłania',
	        	'count' => $this->object_aggs['prawo']['odeslania']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['orzeczenie_do_aktu']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'orzeczenie_do_aktu',
	        	'label' => 'Orzeczenia do aktu',
	        	'count' => $this->object_aggs['prawo']['orzeczenie_do_aktu']['doc_count'],
        	);
        
        if( @$this->object_aggs['prawo']['orzeczenie_tk']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'orzeczenia_tk',
	        	'label' => 'Orzeczenia TK',
	        	'count' => $this->object_aggs['prawo']['orzeczenie_tk']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['podstawa_prawna']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'podstawa_prawna',
	        	'label' => 'Podstawa prawna',
	        	'count' => $this->object_aggs['prawo']['podstawa_prawna']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['tekst_jednolity_do_aktu']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'tekst_jednolity_do_aktu',
	        	'label' => 'Tekst jednolity do aktu',
	        	'count' => $this->object_aggs['prawo']['tekst_jednolity_do_aktu']['doc_count'],
        	);
        	
        if( @$this->object_aggs['prawo']['uchylenia_wynikajace_z']['doc_count'] )
        	$menu['items'][] = array(
	        	'id' => 'uchylenia_wynikajace_z',
	        	'label' => 'Uchylenia wynikające z',
	        	'count' => $this->object_aggs['prawo']['uchylenia_wynikajace_z']['doc_count'],
        	);
                
        return $menu;
	}
	
	public function beforeRender() {
		
		parent::beforeRender();
		
		if( in_array($this->object->getData('typ_id'), array('1')) ) {
		    
		    $this->addBreadcrumb(array(
                'href' => '/prawo/ustawy',
                'label' => 'Ustawy',
            ));
		    
	    } elseif( in_array($this->object->getData('typ_id'), array('3')) ) {
		    
		    $this->addBreadcrumb(array(
                'href' => '/prawo/rozporzadzenia',
                'label' => 'Rozporządzenia',
            ));
		    
	    } elseif( in_array($this->object->getData('typ_id'), array('6', '7', '8', '10', '11', '12')) ) {
		    
		    $this->addBreadcrumb(array(
                'href' => '/prawo/umowy',
                'label' => 'Umowy międzynarodowe',
            ));
		    
	    } elseif( in_array($this->object->getData('typ_id'), array('0', '2', '4', '5', '9', '13', '14', '15')) ) {
		    
		    $this->addBreadcrumb(array(
                'href' => '/prawo/inne',
                'label' => 'Inne akty prawne',
            ));
		    
	    }
	    
	    
		
	}

} 