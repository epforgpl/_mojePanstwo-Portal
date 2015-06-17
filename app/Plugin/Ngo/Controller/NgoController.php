<?php

App::uses('ApplicationsController', 'Controller');

class NgoController extends ApplicationsController
{

    public $settings = array(
        'id' => 'ngo',
        'title' => 'NGO',
        'subtitle' => 'Organizacje pozarządowe w Polsce',
        'headerImg' => 'ngo',
    );

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function addDeclaration()
    {

        $status = $this->Ngo->addDeclaration($this->request->data);
        if ($status) {
            $this->Session->setFlash('Twoje zgłoszenie zostało zapisane. Skontaktujemy się z Tobą w najbliższym czasie.');
        } else {
            $this->Session->setFlash('Wystąpił problem z wysyłaniem zgłoszenia');
        }

        return $this->redirect('/ngo');

    }

    public function view()
    {

        $options = array(
            'searchTitle' => 'Szukaj organizacji pozarządowej...',
            'autocompletion' => array(
                'dataset' => 'ngo',
            ),
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.forma_prawna_typ_id' => '2',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Ngo',
                    'element' => 'cover',
                ),
                'aggs' => array(
                    'fundacje' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'data.krs_podmioty.forma_prawna_id' => '1',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 5,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
                                            'order' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'stowarzyszenia' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'data.krs_podmioty.forma_prawna_id' => '15',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 5,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
                                            'order' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'label' => 'Zbiory danych',
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => array(
                            'krs_podmioty' => 'Organizacje',
                        ),
                    ),
                ),
            ),
        );
		
		$this->_layout['body']['theme'] = 'default';
		
        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }
	
	public function fundacje()
    {
    	        		    		
        $this->loadDatasetBrowser('krs_podmioty', array(
	        'conditions' => array(
		        'krs_podmioty.forma_prawna_id' => '1',
	        ),
        ));
        $this->set('title_for_layout', 'Fundacje | NGO');
		    	    	    
    }
    
    public function stowarzyszenia()
    {
    	        		    		
        $this->loadDatasetBrowser('krs_podmioty', array(
	        'conditions' => array(
		        'krs_podmioty.forma_prawna_id' => '15',
	        ),
        ));
        $this->set('title_for_layout', 'Stowarzyszenia | NGO');
		    	    	    
    }
	
    public function getMenu()
    {
				
		$menu = array(
			'items' => array(),
			'base' => '/' . $this->settings['id'],
		);
		
		$menu['items'][] = array(
			'label' => 'NGO',
			'icon' => array(
				'src' => 'glyphicon',
				'id' => 'home',
			),
		);
		
		$menu['items'][] = array(
			'label' => 'Fundacje',
			'id' => 'fundacje',
		);	
		
		$menu['items'][] = array(
			'label' => 'Stowarzyszenia',
			'id' => 'stowarzyszenia',
		);			
				
		return $menu;

    }

} 