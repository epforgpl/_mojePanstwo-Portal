<?php

App::uses('DataobjectsController', 'Dane.Controller');

class ZamowieniaPubliczneController extends DataobjectsController
{
	
	public $fields = array('zamowienia_publiczne-dokumenty', 'zamowienia_publiczne-wykonawcy', 'zamowienia_publiczne-kryteria');
	
	public function view() {
		
		$this->addInitAggs(array(
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
                                    'data.zamowienia_publiczne_dokumenty.parent_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'scope' => 'global',
                'aggs' => array(
	                'top' => array(
		                'top_hits' => array(
			                'size' => 100,
			                '_source' => array('data', 'details'),
			                'sort' => array(
				                'date' => 'asc',
			                ),
		                ),
	                ),
                ),
            ),
        ));
		
		parent::view();
		
		$this->set('text_details_keys', array(
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
		));
		
		$this->set('types_dictionary', array(
			'1' => 'Ogłoszenie zamówienia',
			'2' => 'Uproszczone ogłoszenie',
			'3' => 'Udzielenie zamówienia',
			'4' => 'Ogłoszenie konkursu',
			'5' => 'Ogłoszenie wyników konkursu',
			'6' => 'Zmiana ogłoszenia',
			'7' => 'Zamiar zawarcia umowy',
		));
				
	}
	
	public function dokumenty() {
		
		$url = '/dane/zamowienia_publiczne/' . $this->request->params['id'] . '#dokument-' . $this->request->params['subid'];
		return $this->redirect( $url );
		
	}
	
} 