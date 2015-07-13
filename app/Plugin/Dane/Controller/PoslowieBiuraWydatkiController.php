<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PoslowieBiuraWydatkiController extends DataobjectsController
{

    public $menu = array();
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array(
            'poslowie_biura_wydatki.wartosc_koszt', 'poslowie_biura_wydatki.wartosc_koszt_posel'
        ),
    );

    public function view()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'dataset' => 'poslowie',
            'order' => 'poslowie.wartosc_biuro_' . $this->object->getData('slug') . ' desc',
            'hlFields' => array('wartosc_biuro_' . $this->object->getData('slug'), 'sejm_kluby.nazwa'),
        ));
    }

    public function beforeRender()
    {

        // debug( $this->object->getData() ); die();

        // PREPARE MENU
        $href_base = '/dane/poslowie_biura_wydatki/' . $this->request->params['id'] . ',' . $this->object->getSlug();

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Ranking posłów',
                ),
            )
        );

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];

        $this->set('_menu', $menu);

    }

} 