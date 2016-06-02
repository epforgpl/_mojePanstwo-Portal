<?php

App::uses('ApplicationsController', 'Controller');

class DaneController extends ApplicationsController
{

    public $settings = array(
        'id' => 'dane',
        'title' => 'Dane publiczne',
        'subtitle' => 'Przeszukuj największą bazę danych publicznych w Polsce',
    );
    
    public $components = array('RequestHandler');
    
    public $mainMenuLabel = 'Szukaj';
    public $appSelected = 'search';

    public function view()
    {
				
		if(
			isset( $this->request->query['q'] ) && 
			!empty( $this->request->query['q'] )
		) {
			
			return $this->redirect('/?q=' . urlencode( $this->request->query['q'] ));
		
		} else {
	
	        $options = array(
	            'searchTitle' => 'Szukaj w danych publicznych...',
	            'autocompletion' => array(
	                'dataset' => '*',
	            ),
	            'conditions' => array(
		            'dataset' => 'zbiory',
		            'zbiory.katalog' => '1',
	            ),
	            'cover' => array(
	                'view' => array(
	                    'plugin' => 'Dane',
	                    'element' => 'cover',
	                ),
	                'aggs' => array(
	                    'top' => array(
	                        'top_hits' => array(
		                        'size' => 500,
		                        'sort' => array(
			                        'title.raw' => array(
				                        'order' => 'asc',
			                        ),
		                        ),
	                        ),
                        ),
                    ),
	            ),
	            'apps' => true,
	            'browserTitle' => 'Wyniki wyszukiwania:',
	        );
			
            $this->_layout['header'] = false;
	        $this->Components->load('Dane.DataBrowser', $options);
	        $this->render('Dane.Elements/DataBrowser/browser-from-app');
        
        }

    }

    public function zbiory()
    {

        $this->title = 'Zbiory danych publicznych';
        $this->loadDatasetBrowser('zbiory', array(
            'conditions' => array(
                'dataset' => 'zbiory',
                'zbiory.katalog' => '1',
            ),
            'order' => '_title asc',
            'limit' => 99,
        ));

    }

    public function action()
    {
				
        if (
        isset($this->request->params['id'])
        ) {
			
			switch( $this->request->params['id'] ) {
				case 'nik_raporty': return $this->redirect('/dane/instytucje/3217,najwyzsza-izba-kontroli/raporty');
				case 'prawo_lokalne': return $this->redirect('/prawo/lokalne');
			}
			
			$dataset_info = $this->getDataset($this->request->params['id']);
						
            if(
	            ( @$this->request->params['ext']!='json' ) && 
            	@$dataset_info['dataset_name']['menu_id']
            ) {

                $url = '/' . $dataset_info['app_id'] . '/' . $dataset_info['dataset_name']['menu_id'] . '?' . http_build_query($this->request->query);
                return $this->redirect($url);

            } else {
	            	            
	            $this->loadModel('Dane.Dataobject');
	            $dataset = $this->Dataobject->find('first', array(
		            'conditions' => array(
			            'dataset' => 'zbiory',
			            'zbiory.slug' => $this->request->params['id'],
		            ),
	            ));
	            	            	            
	            $this->title = $dataset->getData('nazwa');
	            $this->setMetaDescription($dataset->getData('opis'));
	            $this->addBreadcrumb(array(
		            'label' => $dataset->getData('nazwa'),
		            'href' => '/dane/' . $dataset->getData('slug'),
	            ));
	            // $this->_app['name'] = $dataset->getData('nazwa');
	            // $this->_app['href'] = '/dane/' . $dataset->getData('slug');
	            
            }

            $fields = array('searchTitle', 'order');
            $params = array(
	            'observe' => array(
		            'dataset' => $dataset->getDataset(),
		            'object_id' => $dataset->getId(),
	            ),
            );

            foreach ($fields as $field)
                if (isset($data[$field]))
                    $params[$field] = $data[$field];

            $this->menu_selected = $this->request->params['id'];
            $this->loadDatasetBrowser($this->request->params['id'], $params);

        }

    }

    public function getChapters()
    {
        return false;
    }

} 