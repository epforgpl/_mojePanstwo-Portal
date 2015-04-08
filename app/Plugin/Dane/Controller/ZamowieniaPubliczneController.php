<?php

App::uses('DataobjectsController', 'Dane.Controller');

class ZamowieniaPubliczneController extends DataobjectsController
{
    public $menu = array();
    public $objectOptions = array(
        'hlFields' => array('status_id', 'rodzaj_id'),
    );
	
	public $loadChannels = true;
	
    // public $initLayers = array('details', 'sources', 'czesci');
    public $initLayers = array('channels', 'details', 'sources');

    public function view()
    {

        $this->load();
        
        $_details = $this->object->getLayer('details');
        $details = array();
        $text_details = array();


        if (!empty($_details)) {

            // 'siwz_www', 'siwz_adres', 'oferty_miejsce'

            $text_details_keys = array(
                'uprawnienie',
                'wiedza',
                'potencjal',
                'osoby_zdolne',
                'sytuacja_ekonomiczna',
                'zal_pprawna',
                'zal_uzasadnienie',
                'zamowienie_uzupelniajace',
                'wadium',
                'wybor_wykonawcow',
                'zmieniona_umowa',
                'aukcja_www',
                'dk_potrzeby',
                'dk_nagrody',
                'umowa_zabezpieczenia',
                'umowa_istotne_postanowienia',
                'info',
                'inne_dokumenty',
                'inne_dok_potw',
                'zal_pprawna_hid',
                'zamowienie_pprawna',
                'zamowienie_pprawna_hid',
                'zamowienie_uzasadnienie',
                'le_wymagania',
                'le_postapien'
            );


            foreach ($_details as $key => $value) {

                if (!$value) {
                    continue;
                }

                if (in_array($key, $text_details_keys)) {
                    $text_details[$key] = $value;
                } else {
                    $details[$key] = $value;
                }

            }


            if (
                isset($details['siwz_www']) &&
                ($details['siwz_www'] = str_ireplace('nie dotyczy', '', $details['siwz_www'])) &&
                (stripos($details['siwz_www'], 'http') !== 0)
            ) {
                $details['siwz_www'] = 'http://' . $details['siwz_www'];
            }

        }
		
		// debug( $text_details );
		
        $this->set('details', $details);
        $this->set('text_details', $text_details);
        
        $this->feed(array(
	        'direction' => 'asc',
	        'timeline' => true,
	        'searchTitle' => 'tym zamówieniu',
        ));

    }
    
    public function dokumenty() {
				
		parent::load();
				
		if( 
			isset($this->request->params['subid']) && 
			( $dokument = $this->Dataobject->find('first', array(
				'conditions' => array(
					'dataset' => 'zamowienia_publiczne_dokumenty',
					'id' => $this->request->params['subid'],
				),
				'layers' => array(
					'details'
				),
			)) )
		) {
			
			$_details = $dokument->getLayer('details');
	        $details = array();
	        $text_details = array();
	
	
	        if (!empty($_details)) {
	
	            // 'siwz_www', 'siwz_adres', 'oferty_miejsce'
	
	            $text_details_keys = array(
	                'uprawnienie',
	                'wiedza',
	                'potencjal',
	                'osoby_zdolne',
	                'sytuacja_ekonomiczna',
	                'zal_pprawna',
	                'zal_uzasadnienie',
	                'zamowienie_uzupelniajace',
	                'wadium',
	                'wybor_wykonawcow',
	                'zmieniona_umowa',
	                'aukcja_www',
	                'dk_potrzeby',
	                'dk_nagrody',
	                'umowa_zabezpieczenia',
	                'umowa_istotne_postanowienia',
	                'info',
	                'inne_dokumenty',
	                'inne_dok_potw',
	                'zal_pprawna_hid',
	                'zamowienie_pprawna',
	                'zamowienie_pprawna_hid',
	                'zamowienie_uzasadnienie',
	                'le_wymagania',
	                'le_postapien'
	            );
	
	
	            foreach ($_details as $key => $value) {
	
	                if (!$value) {
	                    continue;
	                }
	
	                if (in_array($key, $text_details_keys)) {
	                    $text_details[$key] = $value;
	                } else {
	                    $details[$key] = $value;
	                }
	
	            }
	
	
	            if (
	                isset($details['siwz_www']) &&
	                ($details['siwz_www'] = str_ireplace('nie dotyczy', '', $details['siwz_www'])) &&
	                (stripos($details['siwz_www'], 'http') !== 0)
	            ) {
	                $details['siwz_www'] = 'http://' . $details['siwz_www'];
	            }
	
	        }
	
	        $this->set('dokument', $dokument);
	        $this->set('details', $details);
	        $this->set('text_details', $text_details);
			
		} else {
			
			return $this->redirect( $this->object->getUrl() );
			
		}

	}
    
    public function beforeRender()
    {

        // debug( $this->object->getData() ); die();

        // PREPARE MENU
        $href_base = '/dane/zamowienia_publiczne/' . $this->request->params['id'] . ',' . $this->object->getSlug();

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Aktualności',
                    'icon' => 'glyphicon glyphicon-feed',
                ),
            )
        );

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];

        parent::beforeRender();
        

    }
} 