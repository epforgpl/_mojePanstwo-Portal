<?php

App::uses('DataobjectsController', 'Dane.Controller');

class UzytkownicyController extends DataobjectsController
{
    public $collectionsOptions = false;

    public function view() {
        $this->_prepareView();
    }

    public function pisma() {
        $this->request->params['action'] = 'pisma';
        $this->_prepareView();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'pisma',
                'pisma.object_id' => '0',
                'pisma.from_user_id' => $this->object->getId(),
                'pisma.is_public' => 'true',
            ),
            'searchTitle' => 'Szukaj w pismach...'
        ));

        $this->set('title_for_layout', 'Pisma użytkownika ' . $this->object->getData('username'));
    }

    public function kolekcje() {
        $this->request->params['action'] = 'kolekcje';
        $this->_prepareView();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'kolekcje',
                'kolekcje.object_id' => '0',
                'kolekcje.is_public' => 'true',
                'kolekcje.user_id' => $this->object->getId(),
            ),
            'searchTitle' => 'Szukaj w kolekcjach...'
        ));

        $this->set('title_for_layout', 'Kolekcje użytkownika ' . $this->object->getData('nazwa'));
    }

    public function _prepareView() {
        $this->addInitAggs(array(
            'pisma' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'pisma',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.pisma.object_id' => '0',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.pisma.is_public' => 'true',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.pisma.from_user_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'fielddata_fields' => array('dataset', 'id'),
                            'size' => 3,
                            'sort' => array(
                                'date' => 'desc',
                            ),
                        ),
                    ),
                ),
                'scope' => 'global',
            ),
            'kolekcje' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'kolekcje',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.kolekcje.user_id' => $this->request->params['id'],
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.kolekcje.is_public' => 'true',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.kolekcje.object_id' => '0',
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'fielddata_fields' => array('dataset', 'id'),
                            'size' => 3,
                            'sort' => array(
                                'date' => 'desc',
                            ),
                        ),
                    ),
                ),
                'scope' => 'global',
            ),
        ));

        parent::_prepareView();
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

        if(@$this->object_aggs['pisma']['doc_count']) {
            $menu['items'][] = array(
                'id' => 'pisma',
                'label' => 'Pisma',
                'count' => @$this->object_aggs['pisma']['doc_count'],
            );
        }

        if(@$this->object_aggs['kolekcje']['doc_count']) {
            $menu['items'][] = array(
                'id' => 'kolekcje',
                'label' => 'Kolekcje',
                'count' => @$this->object_aggs['kolekcje']['doc_count'],
            );
        }

        return $menu;
    }

}