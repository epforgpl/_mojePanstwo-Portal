<?php

App::uses('DataobjectsController', 'Dane.Controller');

class ZbiorkiPubliczneController extends DataobjectsController
{

    public function view() {
        $this->_prepareView();
    }

    public function getMenu() {
        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Podstawowe dane',
                    'icon' => array(
                        'src' => 'glyphicon',
                        'id' => 'home',
                    ),
                ),
            ),
            'base' => $this->object->getUrl(),
        );

        return $menu;
    }

}
