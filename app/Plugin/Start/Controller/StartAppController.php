<?php

App::uses('ApplicationsController', 'Controller');

class StartAppController extends ApplicationsController {

    public $settings = array(
        'id' => 'start',
        'title' => 'Start',
    );

    public $mainMenuLabel = 'Start';

    public $submenus = array(
        'start' => array(
            'items' => array(
                array(
                    'id' => 'subscriptions',
                    'label' => 'Powiadomienia',
                    'href' => '/moje-powiadomienia',
                    'icon' => 'icon-applications-powiadomienia',
                    'submenu' => array(
	                    'items' => array(
                            array(
                                'id' => '',
                                'href' => '/',
                                'label' => 'Nowe dane',
                            ),
		                    array(
			                    'id' => 'subscriptions',
                                'href' => '/obserwuje',
			                    'label' => 'Rzeczy, które obserwuję',
		                    ),
		                ),
                    ),
                ),
                array(
                    'id' => 'letters',
                    'label' => 'Pisma',
                    'href' => '/moje-pisma',
                    'icon' => 'icon-applications-pisma',
                    'submenu' => array(
	                    'items' => array(
                            array(
                                'id' => '',
                                'href' => '/',
                                'label' => 'Moje pisma',
                            ),
		                    array(
			                    'id' => 'nowe',
                                'href' => '/nowe',
			                    'label' => 'Napisz nowe pismo',
		                    ),
		                ),
                    ),
                ),
                array(
                    'id' => 'collections',
                    'label' => 'Kolekcje',
                    'href' => '/moje-kolekcje',
                    'icon' => 'icon-datasets-kolekcje',
                    'submenu' => array(
	                    'items' => array(
                            array(
                                'id' => '',
                                'href' => '/',
                                'label' => 'Moje kolekcje',
                            ),
		                    array(
			                    'id' => 'nowe',
                                'href' => '/nowe',
			                    'label' => 'Stwórz nową kolekcję',
		                    ),
		                ),
                    ),
                ),
            )
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Auth->user())
            throw new ForbiddenException;
    }

    public function getChapters() {

        $mode = false;
		
		/*
        $items = array(
            array(
                'label' => 'Start',
                'href' => '/' . $this->settings['id'],
            ),
        );
        */
        $items = array();

        if( isset($this->viewVars['dataBrowser']['aggs']['dataset']) && !empty($this->viewVars['dataBrowser']['aggs']['dataset']) ) {

            $keys = array();
            foreach( $this->viewVars['dataBrowser']['aggs']['dataset'] as $k => $v )
                if( @$v['doc_count'] )
                    $keys[] = $k;

            $items[] = array(
                'id' => '_results',
                'label' => 'Wyniki wyszukiwania',
                'href' => '/' . $this->settings['id'] . '?q=' . urlencode( $this->request->query['q'] ),
            );

            if( $this->chapter_selected=='view' )
                $this->chapter_selected = '_results';
            $mode = 'results';


            foreach( $this->submenus['prawo']['items'] as $item ) {
                if( in_array($item['id'], $keys) ) {
                    $item['href'] .= '?q=' . urlencode( $this->request->query['q'] );
                    $items[] = $item;
                }
            }


        } else {

            $items = array_merge($items, $this->submenus['start']['items']);

        }

        $output = array(
            'items' => $items,
            'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
        );

        return $output;

    }

}
