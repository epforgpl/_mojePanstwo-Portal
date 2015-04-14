<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PowiatyController extends DataobjectsController
{

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
        $this->set('DataBrowserTitle', 'Gminy w tym powiecie');
        $this->render('DataBrowser/browser');


    }

} 