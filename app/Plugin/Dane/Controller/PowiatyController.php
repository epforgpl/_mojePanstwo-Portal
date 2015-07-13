<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PowiatyController extends DataobjectsController
{
    
    public $addDatasetBreadcrumb = false;
    
    public function view()
    {

        $this->addInitLayers(array('gmina'));
        parent::load();

        if (($this->object->getData('typ_id') == '2') || ($this->object->getData('typ_id') == '3')) {
            if ($gmina_id = $this->object->getLayer('gmina')) {

                $this->redirect('/dane/gminy/' . $gmina_id);

            }
        }

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'gminy',
                'gminy.powiat_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'gminy',
        ));

        $this->set('title_for_layout', 'Gminy w powiecie ' . ' ' . $this->object->getData('nazwa'));
        $this->render('DataBrowser/browser');


    }
    
    public function getMenu()
    {
	    
	    $menu = array(
		    'items' => array(
			    array(
				    'id' => '',
				    'label' => 'Gminy w powiecie',
			    ),
		    ),
		    'base' => $this->object->getUrl(),
	    );
	    
	    return $menu;
	    
    }
    
    public function beforeRender()
    {
	    parent::beforeRender();
	 	if( $this->object ) {
	 		 		
		    $this->addBreadcrumb(array(
	            'href' => '/dane/wojewodztwa/' . $this->object->getData('wojewodztwa.id'),
	            'label' => 'Województwo ' . lcfirst($this->object->getData('wojewodztwa.nazwa')),
	        ));
	                
        }   
    }

} 