<?php

App::uses('DataobjectsController', 'Dane.Controller');

class SnSedziowieController extends DataobjectsController
{

    public function view()
    {

        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'sn_sedziowie.orzeczenia:' . $this->object->getId(),
            'dataset' => 'sn_orzeczenia',
            /*
            'excludeFilters' => array(
                'wojewodztwo_id',
            ),
            */
        ));

        // $this->set('title_for_layout', __d('dane', 'LC_DANE_GMINY_W_WOJEWODZTWIE') . ' ' . $this->object->getData('nazwa'));

    }

    public function beforeRender()
    {

        // PREPARE MENU
        $href_base = '/dane/sn_sedziowie/' . $this->request->params['id'];

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Orzeczenia',
                ),
            )
        );

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];
        $this->set('_menu', $menu);

    }
} 