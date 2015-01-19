<?php

App::uses('DataobjectsController', 'Dane.Controller');

class ZbioryController extends DataobjectsController
{

    public function view()
    {
		
		if( isset($this->request->params['alias']) ) {
					
			$this->params->id = $this->params->alias;
			$this->search_field = 'zbiory.slug';
		
		} else {
			
			parent::_prepareView();
			return $this->redirect('/dane/' . $this->object->getData('slug'));
			
		}
		
		parent::_prepareView();		
        
        $this->dataobjectsBrowserView(array(
            'dataset' => $this->object->getData('slug'),
            'limit' => 50
        ));

        $this->set('title_for_layout', $this->object->getData('nazwa'));

    }

    public function beforeRender()
    {

        // PREPARE MENU
        $href_base = '/dane/' . $this->object->getData('slug');

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Dane',
                ),
            )
        );

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];
        $this->set('_menu', $menu);

    }
} 