<?php

App::uses('DataobjectsController', 'Dane.Controller');

class MSiGController extends DataobjectsController
{

    public $initLayers = array('toc');
    public $helpers = array('Document');

    public $objectOptions = array(
        // 'hlFields' => array('isap_status_str', 'sygnatura', 'data_wydania', 'data_publikacji', 'data_wejscia_w_zycie'),
        'hlFields' => array(),
    );


    public function view($package = 1)
    {
				
        $this->_prepareView();
        
        $this->DataBrowser = $this->Components->load('Dane.DataBrowser', array(
            'browserTitle' => 'Wyniki wyszukiwania w ogłoszeniach:',
            'conditions' => array(
                'dataset' => 'msig_pozycje',
                'msig_pozycje.wydanie_id' => $this->object->getId(),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'msig_pozycje/cover',
                ),
                'aggs' => array(
	                'dzialy' => array(
			            'terms' => array(
				            'field' => 'msig_dzialy.typ_id',
				            'order' => array(
					            'pozycja' => 'asc',
				            ),
			            ),
			            'aggs' => array(
				            'pozycja' => array(
					            'min' => array(
						            'field' => 'data.msig_pozycje.pozycja',
					            ),
				            ),
				            'formy' => array(
					            'terms' => array(
						            'field' => 'data.msig_pozycje.krs_forma_prawna_id',
						            'size' => 100,
					            ),
				            ),
			            ),
		            ),
		            'formy' => array(
			            'terms' => array(
				            'field' => 'msig_pozycje.krs_forma_prawna_id',
				            'order' => array(
					            'pozycja' => 'asc',
				            ),
			            ),
			            'aggs' => array(
				            'pozycja' => array(
					            'min' => array(
						            'field' => 'data.msig_pozycje.pozycja',
					            ),
				            ),
				            'dzialy' => array(
					            'terms' => array(
						            'field' => 'data.msig_dzialy.typ_id',
						            'size' => 1,
					            ),
				            ),
			            ),
		            ),
                ),
            ),
            'objectOptions' => array(
	            'from_msig' => true,
            ),
            'phrasesPreset' => 'msig_pozycje',
            'aggsPreset' => 'msig_pozycje',
        ));
        
        $this->render('Dane.DataBrowser/browser');
    
    }	
	
    public function dokument()
    {

        $this->_prepareView();

        $this->render('view');

    }

    public function dzialy()
    {

        $this->load();

        if ($id = @$this->request->params['subid']) {

            $dzial = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'msig_dzialy',
                    'id' => $id,
                ),
            ));

            if ($dzial->getData('msig_id') != $this->object->getId()) {

                $this->redirect('/dane/msig/' . $dzial->getData('msig_id') . '/dzialy/' . $dzial->getId());
                die();

            }

            $this->set('dzial', $dzial);
            $this->set('title_for_layout', $dzial->getTitle());
            $this->render('dzial');

        } else {
            $this->redirect('/dane/msig/' . $this->object->getId());
        }

    }

    public function beforeRender()
    {


        // PREPARE MENU
        $href_base = '/dane/msig/' . $this->request->params['id'];

        $menu = array(
            'items' => array(
                array(
	                'id' => '',
	                'label' => 'Ogłoszenia',
                ),
                array(
	                'id' => 'dokument',
	                'label' => 'Dokument',
	                'href' => $href_base . '/dokument'
                ),
            )
        );

        $this->menu = $menu;
        parent::beforeRender();
        
        $set = array(
	        'dzialy' => array(),
	        'formy' => array(),
        );

        if( $_dzialy = @$this->viewVars['dataBrowser']['aggs']['dzialy']['buckets'] ) {
	       foreach( $_dzialy as $d ) {
		       
		       $formy = array();
		       if( $_formy = @$d['formy']['buckets'] )
			       foreach( $_formy as $f )
						$formy[] = array(
							'id' => $f['key'],
							'title' => $this->DataBrowser->dict('krs_formy_prawne', $f['key'], 'plural'),
							'count' => $f['doc_count'],
						);
			       		       
		       $set['dzialy'][] = array(
			       'id' => $d['key'],
			       'title' => $this->DataBrowser->dict('msig_dzialy_typy', $d['key'], 'plural'),
			       'count' => $d['doc_count'],
			       'formy' => $formy,
		       );
		       
	       }
        }
        
        if( $_formy = @$this->viewVars['dataBrowser']['aggs']['formy']['buckets'] ) {
	       foreach( $_formy as $f ) {
		       
		       $dzialy = array();
		       if( $_dzialy = @$f['dzialy']['buckets'] )
			       foreach( $_dzialy as $d )
						$dzialy[] = array(
							'id' => $d['key'],
							'title' => $this->DataBrowser->dict('msig_dzialy_typy', $d['key'], 'plural'),
							'count' => $d['doc_count'],
						);
			       		       
		       $set['formy'][] = array(
			       'id' => $f['key'],
			       'title' => $this->DataBrowser->dict('krs_formy_prawne', $f['key'], 'plural'),
			       'count' => $f['doc_count'],
			       'dzialy' => $dzialy,
		       );
		       
	       }
        }
        
        
        unset( $this->viewVars['dataBrowser']['aggs']['dzialy'] );
        unset( $this->viewVars['dataBrowser']['aggs']['formy'] );
        $this->set('_dzialy', $set['dzialy']);
        $this->set('_formy', $set['formy']);
        
    }

} 