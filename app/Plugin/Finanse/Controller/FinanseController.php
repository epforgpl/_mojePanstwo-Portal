<?php

App::uses('ApplicationsController', 'Controller');

class FinanseController extends ApplicationsController
{

    public $settings = array(
        'id' => 'finanse',
        'title' => 'Finanse',
        'subtitle' => 'Przeglądaj informacje o finansach Polski',
    );

	public function view()
	{
		
        $options = array(
            'searchTitle' => 'Szukaj w budżetach krajowych...',
            'conditions' => array(
                'dataset' => 'budzety',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Finanse',
                    'element' => 'budzety-cover',
                ),
                'aggs' => array(
	                'budzety' => array(
		                'filter' => array(
			                'bool' => array(
				                'must' => array(
					                array(
						                'term' => array(
							                'dataset' => 'budzety',
						                ),
					                ),
					                array(
						                'range' => array(
							                'data.budzety.rok' => array(
								                'gte' => 1989
							                ),
						                ),
					                ),
				                ),
			                ),
		                ),
		                'aggs' => array(
			                'top' => array(
				                'top_hits' => array(
					                'size' => 100,
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
            'apps' => true,
        );
		
		$this->chapter_selected = 'view';
        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
        
	}
    
    public function getChapters() {
	    
	    return array(
		    'items' => array(
			    array(
				    'href' => '/finanse',
				    'label' => 'Budżety krajowe',
			    ),
			    array(
				    'id' => 'samorzad',
				    'href' => '/finanse/samorzad',
				    'label' => 'Budżety samorządu terytorialnego',
			    ),
		    ),
	    );
	    
    }

}
