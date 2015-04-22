<?php

App::uses('ApplicationsController', 'Controller');
class DaneController extends ApplicationsController
{
	
    public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Wyszukiwarka',
			),
			array(
				'id' => 'zbiory',
				'label' => 'Zbiory danych',
			),
		),
		'title' => 'Dane',
		'subtitle' => 'Największa baza danych publicznych w Polsce',
		'headerImg' => 'dane',
	);
	
    public function view()
    {
        
        $this->setMenuSelected();
        
        if(
	        isset( $this->request->query['q'] ) && 
	        $this->request->query['q']
        ) {

            if(isset($this->request->query['conditions']['dataset'])) {
                $query = $this->request->query;
                $dataset = $query['conditions']['dataset'];
                unset($query['conditions']['dataset']);
                $this->redirect('/dane/' . $dataset . '?' . http_build_query($query));
            }
		    	    
		    $this->Components->load('Dane.DataBrowser', array(
			    'conditions' => array(
				    'q' => $this->request->query['q'],
				    '_main' => true,
			    ),
			    'aggs' => array(
				    'dataset' => array(
			            'terms' => array(
				            'field' => 'dataset',
			            ),
			            'aggs' => array(
				            'label' => array(
					            'terms' => array(
						            'field' => 'dataset',
					            ),
				            ),
			            ),
			            'visual' => array(
				            'label' => 'Zbiory danych',
				            'skin' => 'pie_chart',
		                    'field' => 'dataset'
			            ),
			        ),
				    'date' => array(
			            'date_histogram' => array(
				            'field' => 'date',
				            'interval' => 'year',
				            'format' => 'yyyy-MM-dd',
			            ),
			            'visual' => array(
				            'label' => 'Dane w czasie',
				            'skin' => 'date_histogram',
		                    'field' => 'date'
			            ),
			        ),
			    ),
		    ));
		    
		    $this->set('dataBrowserObjectRender', array(
			    'forceLabel' => true,
		    ));
		    
		    $this->title = $this->request->query['q'] . ' - Dane publiczne';
		    $this->render('Dane.Elements/DataBrowser/browser-from-app');
	        
        } else {
	        
	        $this->title = 'Dane publiczne';
	        
        }
        
        // $this->loadDatasetBrowser('instytucje', $options);
                
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

} 