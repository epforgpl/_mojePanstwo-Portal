<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PoslowieController extends DataobjectsController
{

    public $components = array(
        'RequestHandler',
    );

    public $menu = array();
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array('sejm_kluby.nazwa'),
    );

    public $headerObject = array('url' => '/dane/img/headers/poslowie.jpg', 'height' => '250px');

    public function view()
    {

        // $this->addInitLayers(array('terms'));
        parent::load();

        $this->feed();

        /*
        if (($terms = $this->object->getLayer('terms')) && !empty($terms)) {

            $font = array(
                'min' => 15,
                'max' => 100,
            );
            $font['diff'] = $font['max'] - $font['min'];


            foreach ($terms as &$term) {
                $term['size'] = $font['min'] + $font['diff'] * $term['norm_score'];
            }


            shuffle($terms);
            $this->set('terms', $terms);

        }


        $this->API->searchDataset('prawo_projekty', array(
            'limit' => 8,
            'conditions' => array(
                'poslowie_za' => $this->object->getId(),
            ),
            'order' => 'data_status desc',
        ));
        $this->set('projekty_za', $this->API->getObjects());


        $this->API->searchDataset('prawo_projekty', array(
            'limit' => 8,
            'conditions' => array(
                'poslowie_przeciw' => $this->object->getId(),
            ),
            'order' => 'data_status desc',
        ));
        $this->set('projekty_przeciw', $this->API->getObjects());


        $this->API->searchDataset('prawo_projekty', array(
            'limit' => 8,
            'conditions' => array(
                'poslowie_wstrzymali' => $this->object->getId(),
            ),
            'order' => 'data_status desc',
        ));
        $this->set('projekty_wstrzymania', $this->API->getObjects());


        $this->API->searchDataset('prawo_projekty', array(
            'limit' => 8,
            'conditions' => array(
                'poslowie_nieobecni' => $this->object->getId(),
            ),
            'order' => 'data_status desc',
        ));
        $this->set('poslowie_nieobecni', $this->API->getObjects());
        */

        /*
        $menu = array(
            array(
                'id' => 'wystapienia',
                'label' => 'Wystąpienia w Sejmie',
            ),
            array(
                'id' => 'interpelacje',
                'label' => 'Interpelacje',
            ),
            array(
                'id' => 'wystapienia',
                'label' => 'Projekty ustaw',
            ),
            array(
                'id' => 'glosowania',
                'label' => 'Wyniki głosowań',
            ),
        );


        $this->API->searchDataset('sejm_wystapienia', array(
            'limit' => 9,
            'conditions' => array(
                'ludzie.id' => $this->object->getData('ludzie.id'),
            ),
        ));
        $this->set('wystapienia', $this->API->getObjects());

        $this->API->searchDataset('sejm_interpelacje', array(
            'limit' => 9,
            'conditions' => array(
                'posel_id' => $this->object->getId(),
            ),
        ));
        $this->set('interpelacje', $this->API->getObjects());

        $this->API->searchDataset('legislacja_projekty_ustaw', array(
            'limit' => 9,
            'conditions' => array(
                'posel_id' => $this->object->getId(),
            ),
        ));
        $this->set('projekty_ustaw', $this->API->getObjects());

        $this->API->searchDataset('poslowie_glosy', array(
            'limit' => 9,
            'conditions' => array(
                'posel_id' => $this->object->getId(),
            ),
        ));
        $this->set('glosowania', $this->API->getObjects());


        // $this->set('info', $this->object->loadLayer('info'));
        // $this->set('krs', $this->object->loadLayer('krs'));
        // $this->set('stats', $this->object->loadLayer('stat'));

        $this->set('_menu', $menu);
        */
    }


    public function twitter()
    {

        parent::view();

        if (
            $this->object->getData('twitter_account_id') &&
            ($twitter_account = $this->API->Dane()->getObject('twitter_accounts', $this->object->getData('twitter_account_id')))
        ) {

            $this->set('twitter_account', $twitter_account);

            $twitter_account->loadLayer('followers_chart');

            $this->API->searchDataset('twitter', array(
                'limit' => 12,
                'conditions' => array(
                    'twitter_account_id' => $twitter_account->getId(),
                ),
            ));
            $this->set('twitts', $this->API->getObjects());

        } else {
            $this->redirect('/dane/poslowie/' . $this->object->getId());
        }

    }

    public function wyjazdy()
    {

        $this->addInitLayers(array('wyjazdy'));
        parent::view();

        $this->set('title_for_layout', "Wyjazdy zagraniczne " . $this->object->getData('dopelniacz'));

    }


    public function wydatki()
    {

		$this->addInitLayers(array('wydatki'));
        $this->load();
		
		$wydatki = $this->object->getLayer('wydatki');
        $rok = @$this->request->params['subid'];
        
        		
        if ($rok && ($roczniki = $wydatki['roczniki'])) {

            $founded = false;

            foreach ($roczniki as $rocznik) {
                if ($rocznik['rok'] == $rok) {
                    $founded = true;
                    break;
                }
            }

            if (!$founded) {
                $this->redirect('/dane/poslowie/' . $this->object->getId() . '/wydatki');
            }

            $this->set(array(
                'rocznik' => $rocznik,
                'title_for_layout' => 'Wydatki biura ' . $this->object->getData('dopelniacz') . ' w ' . $rok . ' roku',
            ));
            $this->render('wydatki_rok');

        } else {

            $this->set('title_for_layout', $this->object->getData('nazwa') . ' | Informacje finansowe');
			
			/*
            $this->API->searchDataset('poslowie_oswiadczenia_majatkowe', array(
                'limit' => 9,
                'conditions' => array(
                    'posel_id' => $this->object->getId(),
                ),
                'order' => 'data_status desc',
            ));
            $this->set('oswiadczenia_majatkowe', $this->API->getObjects());


            $this->API->searchDataset('poslowie_rejestr_korzysci', array(
                'limit' => 9,
                'conditions' => array(
                    'posel_id' => $this->object->getId(),
                ),
                'order' => 'data_status desc',
            ));
            $this->set('rejestr_korzysci', $this->API->getObjects());


            $this->API->searchDataset('poslowie_wspolpracownicy', array(
                'limit' => 9,
                'conditions' => array(
                    'posel_id' => $this->object->getId(),
                ),
                'order' => 'data_status desc',
            ));
            $this->set('wspolpracownicy', $this->API->getObjects());
			*/

        }

    }

    public function oswiadczenia_majatkowe()
    {
		
		$this->load();
		
		$this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'poslowie_oswiadczenia_majatkowe',
	            'poslowie_oswiadczenia_majatkowe.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'oswiadczenia_majatkowe',
        ));
        
        $this->set('title_for_layout', 'Oświadczenia majątkowe ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Oświadczenia majątkowe ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function rejestr_korzysci()
    {
		
		$this->load();
		
		$this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'poslowie_rejestr_korzysci',
	            'poslowie_rejestr_korzysci.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'oswiadczenia_majatkowe',
        ));
        
        $this->set('title_for_layout', 'Rejestr korzyści ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Rejestr korzyści ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');
        
    }

    public function wspolpracownicy()
    {
		
		$this->load();
		
		$this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'poslowie_wspolpracownicy',
	            'poslowie_wspolpracownicy.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'poslowie_wspolpracownicy',
        ));
        
        $this->set('title_for_layout', 'Współpracownicy ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Współpracownicy ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');
		
    }

    public function wystapienia()
    {
	    
        parent::load();
                
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'sejm_wystapienia',
	            'ludzie.id' => $this->object->getData('poslowie.mowca_id'),
            ),
            'aggsPreset' => 'sejm_wystapienia',
        ));
        
        $this->set('title_for_layout', 'Wystąpienia sejmowe ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Wystąpienia sejmowe ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function interpelacje()
    {
        parent::load();
	    $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'sejm_interpelacje',
	            'sejm_interpelacje.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'sejm_wystapienia',
        ));
        
        $this->set('title_for_layout', 'Interpelacje ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Interpelacje ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');
	    
    }

    public function projekty_ustaw()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'poslowie.projekty_ustaw:' . $this->object->getId(),
            'dataset' => 'legislacja_projekty_ustaw',
            'title' => 'Złożone projekty ustaw',
            'noResultsTitle' => 'Brak projektów',
        ));
    }

    public function glosowania()
    {
	    
	    $this->load();
		
		$this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
	            'dataset' => 'poslowie_glosy',
	            'poslowie_glosy.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'poslowie_glosy',
        ));
        
        $this->set('title_for_layout', 'Wyniki głosowań ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Wyniki głosowań ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');
        
    }

    public function prawo_projekty()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'poslowie.prawo_projekty:' . $this->object->getId(),
            'dataset' => 'prawo_projekty',
            'title' => 'Projekty wniesionych aktów prawnych',
            'noResultsTitle' => 'Brak projektów',
        ));

        $this->set('title_for_layout', 'Projekty aktów prawnych, które wniósł do Sejmu ' . $this->object->getData('nazwa'));

    }

    public function prawo_projekty_za()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'poslowie.prawo_projekty_za:' . $this->object->getId(),
            'dataset' => 'prawo_projekty',
            'title' => 'Projekty aktów prawnych, za którymi głosował poseł',
            'noResultsTitle' => 'Brak projektów',
        ));

        $this->set('title_for_layout', 'Projekty aktów prawnych, za którymi głosował ' . $this->object->getData('nazwa'));

    }

    public function prawo_projekty_przeciw()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'poslowie.prawo_projekty_przeciw:' . $this->object->getId(),
            'dataset' => 'prawo_projekty',
            'title' => 'Projekty aktów prawnych, przeciw którym głosował poseł',
            'noResultsTitle' => 'Brak projektów',
        ));

        $this->set('title_for_layout', 'Projekty aktów prawnych, przeciw którym głosował ' . $this->object->getData('nazwa'));

    }

    public function prawo_projekty_wstrzymanie()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'poslowie.prawo_projekty_wstrzymanie:' . $this->object->getId(),
            'dataset' => 'prawo_projekty',
            'title' => 'Projekty aktów prawnych, nad którymi poseł wstrzymał się od głosu',
            'noResultsTitle' => 'Brak projektów',
        ));

        $this->set('title_for_layout', 'Projekty aktów prawnych, nad którymi ' . $this->object->getData('nazwa') . ' wstrzymał się od głosu');

    }

    public function prawo_projekty_nieobecnosc()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'poslowie.prawo_projekty_nieobecnosc:' . $this->object->getId(),
            'dataset' => 'prawo_projekty',
            'title' => 'Projekty aktów prawnych, dla których poseł nie przyszedł na głosowanie',
            'noResultsTitle' => 'Brak projektów',
        ));

        $this->set('title_for_layout', 'Projekty aktów prawnych, dla których ' . $this->object->getData('nazwa') . ' nie przyszedł na głosowanie');

    }

    public function komisja_etyki_uchwaly()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'poslowie.komisja_etyki_uchwaly:' . $this->object->getId(),
            'dataset' => 'sejm_komisje_uchwaly',
            'title' => 'Uchwały Komisji Etyki wobec posła',
            'noResultsTitle' => 'Brak uchwał',
        ));

        $this->set('title_for_layout', 'Uchwały Komisji Etyki wobec ' . $this->object->getData('dopelniacz'));
    }


    public function beforeRender()
    {

        // debug( $this->object->getData() ); die();

        // PREPARE MENU
        $href_base = '/dane/poslowie/' . $this->request->params['id'] . ',' . $this->object->getSlug();

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

        $menu['items'][] = array(
            'id' => 'dane',
            'label' => 'Dane',
            'icon' => 'glyphicon glyphicon-align-justify',
            'dropdown' => array(
                'items' => array(
                    array(
                        'id' => 'wystapienia',
                        'href' => $href_base . '/wystapienia',
                        'label' => 'Wystąpienia',
                    ),
                    array(
                        'id' => 'glosowania',
                        'href' => $href_base . '/glosowania',
                        'label' => 'Wyniki głosowsań',
                    ),
                    array(
                        'id' => 'interpelacje',
                        'href' => $href_base . '/interpelacje',
                        'label' => 'Interpelacje',
                    ),
                    array(
                        'id' => 'wspolpracownicy',
                        'href' => $href_base . '/wspolpracownicy',
                        'label' => 'Współpracownicy',
                        'topborder' => true,
                    ),
                    array(
                        'id' => 'oswiadczenia_majatkowe',
                        'href' => $href_base . '/oswiadczenia_majatkowe',
                        'label' => 'Oświadczenia majątkowe',
                    ),
                    array(
                        'id' => 'rejestr_korzysci',
                        'href' => $href_base . '/rejestr_korzysci',
                        'label' => 'Rejestr korzyści',
                    ),
                ),
            ),
        );

        $menu['items'][] = array(
            'id' => 'wydatki',
            'href' => $href_base . '/wydatki',
            'label' => 'Wydatki',
            'icon' => 'glyphicon glyphicon-spendings',
        );

        $menu['items'][] = array(
            'id' => 'wyjazdy',
            'href' => $href_base . '/wyjazdy',
            'label' => 'Wyjazdy zagraniczne',
            'icon' => 'glyphicon glyphicon-travels',
        );

        if ($this->object->getData('twitter_account_id')) {
            $menu['items'][] = array(
                'id' => 'twitter',
                'href' => $href_base . '/twitter',
                'label' => 'Twitter',
            );
        }

        $this->menu = $menu;
        parent::beforeRender();

    }

}