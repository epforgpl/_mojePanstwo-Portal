<?php

App::uses('DataobjectsController', 'Dane.Controller');

class KrsPodmiotyController extends DataobjectsController
{
    public $menu = array();
    public $helpers = array(
        'Time',
    );
    public $components = array('RequestHandler');
    public $objectOptions = array(
        'hlFields' => array(),
        'bigTitle' => true,
    );
	
	public $loadChannels = true;
    public $initLayers = array('counters');

    public $microdata = array(
        'itemtype' => 'http://schema.org/Organization',
        'titleprop' => 'name',
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->deny(array('pobierz_odpis', 'odpis'));
    }

	
	
	public function aktualnosci() {
		
		$this->load();
		
		if( isset($this->request->params['pass'][0]) ) {
						
			$zmiana = $this->API->getObject('krs_podmioty_zmiany', $this->request->params['pass'][0], array(
                'layers' => array('details'),
            ));
            
            $this->request->params['action'] = 'view';
            
            $this->set('zmiana', $zmiana);
            $this->render('aktualnosc');
            
			
		} else {
			
			$this->feed();
			
		}
		
	}

    public function _prepareView()
    {

        parent::_prepareView();

        if (defined('PK_DOMAIN')) {

            $pieces = parse_url(Router::url($this->here, true));
            if (($pieces['host'] == PK_DOMAIN) && ($this->object->getData('gmina_id') != '903')) {

                $this->redirect('http://' . PORTAL_DOMAIN . $_SERVER['REQUEST_URI']);
                die();

            }

        }

    }
	
	
    public function view()
    {

        $this->addInitLayers(array(
	        'channels',
            /*
            'reprezentacja',
            'wspolnicy',
            'jedynyAkcjonariusz',
            'prokurenci',
            'nadzor',
            'komitetZalozycielski',
            'dzialalnosci',
            */
            'udzialy',
            'firmy',
        ));

        if ($this->Session->read('KRS.odpis') == $this->params->id) {
            $this->addInitLayers('odpis');
        }

        $this->_prepareView();

        $desc_parts = array('Informacje gospodarcze o ' . $this->object->getShortTitle());
        $desc_bodies_parts = array();

        if ($this->Session->read('KRS.odpis') == $this->object->getId()) {

            $odpis = $this->object->getLayer('odpis');
            if ($odpis['status']) {
                $this->set('odpis', $odpis['url']);
            }

        }

        $this->Session->delete('KRS.odpis');


        $organy = array();
        $menu = array();

        $reprezentacja = $this->object->getLayer('reprezentacja');
        if (!empty($reprezentacja)) {
            $organy[] = array(
                'title' => $this->object->getData('nazwa_organu_reprezentacji'),
                'label' => 'Organ reprezentacji',
                'idTag' => 'reprezentacja',
                'content' => $reprezentacja,
            );
            $menu[] = array(
                'id' => 'reprezentacja',
                'label' => $this->object->getData('nazwa_organu_reprezentacji'),
            );

            $desc_bodies_parts[] = mb_strtolower($this->object->getData('nazwa_organu_reprezentacji'));
        }

        $wspolnicy = $this->object->getLayer('wspolnicy');
        if ($wspolnicy)
            $desc_bodies_parts[] = 'udziałowcy';


        /*
        if (!empty($wspolnicy)) {
            $organy[] = array(
                'title' => 'Wspólnicy',
                'idTag' => 'wspolnicy',
                'content' => $wspolnicy,
            );
            $menu[] = array(
                'id' => 'wspolnicy',
                'label' => 'Wspólnicy',
            );
        }
        */

        $nadzor = $this->object->getLayer('nadzor');
        if (!empty($nadzor)) {
            $organy[] = array(
                'title' => $this->object->getData('nazwa_organu_nadzoru'),
                'label' => 'Organ nadzoru',
                'idTag' => 'nadzor',
                'content' => $nadzor,
            );
            $menu[] = array(
                'id' => 'nadzor',
                'label' => $this->object->getData('nazwa_organu_nadzoru'),
            );
            $desc_bodies_parts[] = mb_strtolower($this->object->getData('nazwa_organu_nadzoru'));
        }

        $komitetZalozycielski = $this->object->getLayer('komitetZalozycielski');
        if (!empty($komitetZalozycielski)) {
            $organy[] = array(
                'title' => 'Komitet założycielski',
                'idTag' => 'zalozyciele',
                'content' => $komitetZalozycielski,
            );
            $menu[] = array(
                'id' => 'zalozyciele',
                'label' => 'Komitet założycielski',
            );
            $desc_bodies_parts[] = 'komitet założycielski';
        }

        $akcjonariusze = $this->object->getLayer('jedynyAkcjonariusz');
        if (!empty($akcjonariusze)) {
            $organy[] = array(
                'title' => 'Jedyny akcjonariusz',
                'idTag' => 'akcjonariusz',
                'content' => $akcjonariusze,
            );
            $menu[] = array(
                'id' => 'akcjonariusz',
                'label' => 'Jedyny akcjonariusz',
            );

            $desc_bodies_parts[] = 'akcjonariusze';
        }

        $prokurenci = $this->object->getLayer('prokurenci');
        if (!empty($prokurenci)) {
            $organy[] = array(
                'title' => 'Prokurenci',
                'idTag' => 'prokurenci',
                'content' => $prokurenci,
            );
            $menu[] = array(
                'id' => 'prokurenci',
                'label' => 'Prokurenci',
            );
            $desc_bodies_parts[] = 'prokurenci';
        }


        $this->set('organy', $organy);


		/*
		$zamowienia = $this->Dataobject->find('all', array(
			'conditions' => array(
				'dataset' => 'zamowienia_publiczne',
				'krs_podmioty.'
			),
			'limit' => 9,
		));
		
        $zamowienia = $this->API->search(array(
            'limit' => 9,
            'conditions' => array(
                '_source' => 'krs_podmioty.zamowienia:' . $this->object->getId(),
                'dataset' => 'zamowienia_publiczne',
            ),
        ));
        if ($zamowienia)
            $desc_bodies_parts[] = 'realizowane zamówienia publiczne';
        $this->set('zamowienia', $this->API->getObjects());

        $dotacje = $this->API->search(array(
            'limit' => 9,
            'conditions' => array(
                '_source' => 'krs_podmioty.dotacje_ue:' . $this->object->getId(),
                'dataset' => 'dotacje_ue',
            ),
        ));
        if ($dotacje)
            $desc_bodies_parts[] = 'otrzymane dotacje';
        $this->set('dotacje', $this->API->getObjects());
        */

        $desc_bodies_parts[] = 'odpis z KRS';
		
		
		/*
        $dzialalnosc = $this->object->getLayer('dzialalnosci');
        if ($dzialalnosc) {
            $dzialalnosci = array(
                'title' => 'Działalność',
                'idTag' => 'dzialalnosc',
                'content' => $dzialalnosc,
            );
            $desc_bodies_parts[] = 'działalność PKD';
        }
        $menu[] = array(
            'id' => 'dzialalnosc',
            'label' => 'Działalność',
        );

        @$this->set('dzialalnosci', $dzialalnosci);


        $this->set('_menu', $menu);
        */

        $desc_parts[] = ucfirst(implode(', ', $desc_bodies_parts));
        $this->setMetaDesc(implode('. ', $desc_parts) . '.');
        
        return $this->feed();

    }

    public function historia()
    {

        parent::_prepareView();
		
		/*
        $historia = $this->API->searchDataset('msig_zmiany', array(
            'limit' => 1000,
            'conditions' => array(
                'pozycja_id' => $this->object->getId(),
            ),
            'order' => array(
                '_date desc',
                'wpis_id asc',
                'nr_dz asc',
                'nr_rub asc',
                'nr_sub asc',
                'nr_prub_sub asc',
                'numer_label asc',
                '_ord desc',
            ),
        ));
        $this->set('historia', $this->API->getObjects());
        */

        $this->set('title_for_layout', 'Histora zmian w ' . $this->object->getData('nazwa'));

    }
	
	public function powiazania()
	{
		
		$this->addInitLayers(array('powiazania'));
		$this->_prepareView();
		
		debug( $this->object->getLayer('powiazania') ); die();
		
	}
	
    public function graph()
    {
        if (@$this->request->params['ext'] == 'json') {

            $this->addInitLayers('graph');
            $this->_prepareView();
            $data = $this->object->getLayer('graph');

            $this->set('data', $data);
            $this->set('_serialize', 'data');

        } else {
            
            $this->_prepareView();
            
        }
    }

    public function odpis()
    {

        $id = (int)$this->request->params['id'];
        $this->Session->write('KRS.odpis', $id);
        $this->redirect('/dane/krs_podmioty/' . $id);

    }

    public function zamowienia()
    {

        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'krs_podmioty.zamowienia:' . $this->object->getId(),
            'dataset' => 'zamowienia_publiczne',
            'title' => 'Udzielone zamówienia publiczne',
            'noResultsTitle' => 'Brak zamówień publicznych',
        ));
        $this->set('title_for_layout', 'Zamówienia publiczne udzielone ' . $this->object->getTitle());

    }

    public function dotacje()
    {

        $this->_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'krs_podmioty.dotacje_ue:' . $this->object->getId(),
            'dataset' => 'dotacje_ue',
            'title' => 'Udzielone dotacje',
            'noResultsTitle' => 'Brak dotacji',
        ));
        $this->set('title_for_layout', 'Dotacje udzielone ' . $this->object->getTitle());

    }

    public function umowy()
    {

        $this->_prepareView();


        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $this->helpers[] = 'Document';
            $umowa = $this->API->getObject('umowy', $this->request->params['pass'][0], array(
                'layers' => array('neighbours'),
            ));

            $document = $this->API->document($umowa->getData('dokument_id'));
            $this->set('umowa', $umowa);
            $this->set('document', $document);
            $this->set('title_for_layout', $umowa->getTitle());

            $this->render('umowa');

        } else {

            $this->dataobjectsBrowserView(array(
                'source' => 'krs_podmioty.umowy:' . $this->object->getId(),
                'dataset' => 'umowy',
                'noResultsTitle' => 'Brak umów',
                'limit' => 50,
            ));

            $this->set('title_for_layout', 'Umowy cywilnoprawne podpisane przez ' . $this->object->getTitle());

        }

    }

    public function faktury()
    {

        $this->_prepareView();


        if (isset($this->request->params['pass'][0]) && is_numeric($this->request->params['pass'][0])) {

            $this->helpers[] = 'Document';
            $faktura = $this->API->getObject('faktury', $this->request->params['pass'][0], array(
                'layers' => array('neighbours'),
            ));

            $document = $this->API->document($faktura->getData('dokument_id'));
            $this->set('faktura', $faktura);
            $this->set('document', $document);
            $this->set('title_for_layout', $faktura->getTitle());

            $this->render('faktura');

        } else {

            $this->dataobjectsBrowserView(array(
                'source' => 'krs_podmioty.faktury:' . $this->object->getId(),
                'dataset' => 'faktury',
                'noResultsTitle' => 'Brak faktur',
                'limit' => 50,
            ));

            $this->set('title_for_layout', 'Faktury wystawione dla ' . $this->object->getTitle());

        }

    }

    public function emisje_akcji()
    {

        $this->addInitLayers('emisje_akcji');
        $this->_prepareView();
        $this->set('title_for_layout', 'Emisje akcji spółki ' . $this->object->getTitle());

    }

    public function oddzialy()
    {

        $this->addInitLayers('oddzialy');
        $this->_prepareView();
        $this->set('title_for_layout', 'Oddziały ' . $this->object->getTitle());

    }

    public function kultura()
    {

        $this->addInitLayers('kultura');
        $this->_prepareView();
        $this->set('title_for_layout', 'Indeksy kultury dla ' . $this->object->getTitle());

    }

    public function zmiany_umow()
    {

        $this->addInitLayers('zmiany_umow');
        $this->_prepareView();
        $this->set('title_for_layout', 'Zmiany umów ' . $this->object->getTitle());

    }

    public function beforeRender()
    {

        $counters = $this->object->getLayers('counters');

        // PREPARE MENU
        $href_base = $this->object->getUrl();

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Aktualności',
                ),
            )
        );

        $menu['items'][] = array(
            'id' => 'graph',
            'href' => $href_base . '/graph',
            'label' => 'Powiązania'
        );


        if ($this->request->params['id'] == 481129) { // KOMITET KONKURSOWY KRAKÓW 2022

            $menu['items'][] = array(
                'id' => 'umowy',
                'href' => $href_base . '/umowy',
                'label' => 'Podpisane umowy',
                'count' => 94,
            );

            $menu['items'][] = array(
                'id' => 'faktury',
                'href' => $href_base . '/faktury',
                'label' => 'Faktury',
                'count' => 129,
            );
        }

        if ($counters['liczba_oddzialow']) {
            $menu['items'][] = array(
                'id' => 'oddzialy',
                'href' => $href_base . '/oddzialy',
                'label' => 'Oddziały',
                // 'count' => $counters['liczba_oddzialow'],
            );
        }

        /*
        if ( $counters['liczba_zmian_umow'] ) {
            $menu['items'][] = array(
                'id'   => 'zmiany_umow',
                'href' => $href_base . '/zmiany_umow',
                'label' => 'Zmiany umów',
                'count' => $counters['liczba_zmian_umow'],
            );
        }
        */


        if ($this->request->params['action'] == 'kultura') {
            $menu['items'][] = array(
                'id' => 'kultura',
                'href' => $href_base . '/kultura',
                'label' => 'Indeksy kultury',
            );
        }

        $this->menu = $menu;
		parent::beforeRender();
		
    }

}