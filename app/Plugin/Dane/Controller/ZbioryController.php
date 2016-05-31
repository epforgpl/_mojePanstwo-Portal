<?php

App::uses('DataobjectsController', 'Dane.Controller');

class ZbioryController extends DataobjectsController
{

    public function view()
    {

        if (isset($this->request->params['alias'])) {

            $this->params->id = $this->params->alias;
            $this->search_field = 'zbiory.slug';

        } else {

            parent::_prepareView();
            
            if( @$this->request->params['ext']=='json' )
            	return true;
            else
	            return $this->redirect('/dane/' . $this->object->getData('slug'));

        }

        parent::_prepareView();

        $params = array(
            'dataset' => $this->object->getData('slug'),
            'limit' => 50
        );

        if ($this->object->getId() == '185')
            $params['source'] = 'zbiory.katalog:1';

        $this->dataobjectsBrowserView($params);

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