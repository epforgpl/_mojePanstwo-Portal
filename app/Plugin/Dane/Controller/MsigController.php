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
        
        $this->Components->load('Dane.DataBrowser', array(
            'browserTitle' => 'Wystąpienia radnego',
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
				            'field' => 'msig_pozycje.dzial_id',
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
				            'nazwa' => array(
					            'terms' => array(
						            'field' => 'data.msig_dzialy.nazwa',
						            'size' => 1,
					            ),
				            ),
				            'top' => array(
					            'top_hits' => array(
						            'size' => 3,
						            'sort' => array(
							            'data.msig_pozycje.pozycja' => array(
								            'order' => 'asc',
							            ),
						            ),
						            'fields' => array('dataset', 'id'),
						            '_source' => true,
					            ),
				            ),
			            ),
		            ),
                ),
            ),
            // 'aggsPreset' => 'rady_gmin_wystapienia',
            // 'renderFile' => 'radni_gmin/rady_gmin_wystapienia',
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
	                'id' => 'indeks',
	                'label' => 'Indeks',
	                'href' => $href_base . '/indeks'
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

    }

} 