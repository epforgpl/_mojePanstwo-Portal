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
                    /*
                    'submenu' => array(
	                    'items' => array(
                            array(
                                'id' => 'index',
                                'href' => '/',
                                'label' => 'Nowe dane',
                            ),
		                    array(
			                    'id' => 'subscriptions',
                                'href' => '/obserwuje',
			                    'label' => 'Sprawy, które obserwuję',
		                    ),
		                ),
                    ),
                    */
                ),
                array(
                    'id' => 'letters',
                    'label' => 'Pisma',
                    'href' => '/moje-pisma',
                    'icon' => 'icon-applications-pisma',
                    /*
                    'submenu' => array(
	                    'items' => array(
                            array(
                                'id' => 'my',
                                'href' => '/',
                                'label' => 'Moje pisma',
                            ),
		                    array(
			                    'id' => 'home',
                                'href' => '/nowe',
			                    'label' => 'Napisz nowe pismo',
		                    ),
		                ),
                    ),
                    */
                ),
                array(
                    'id' => 'collections',
                    'label' => 'Kolekcje',
                    'href' => '/moje-kolekcje',
                    'icon' => 'icon-datasets-kolekcje',
                    /*
                    'submenu' => array(
	                    'items' => array(
                            array(
                                'id' => 'index',
                                'href' => '/',
                                'label' => 'Moje kolekcje',
                            ),
		                    array(
			                    'id' => 'add',
                                'href' => '/nowe',
			                    'label' => 'Stwórz nową kolekcję',
		                    ),
		                ),
                    ),
                    */
                ),
                array(
                    'id' => 'account',
                    'label' => 'Ustawienia konta',
                    'href' => '/konto',
                    'icon' => 'icon-datasets-users',
                ),
                array(
                    'id' => 'pages',
                    'label' => 'Strony którymi zarządzam',
                    'href' => '/moje-strony',
                    'icon' => 'icon-datasets-strony',
                ),
                array(
                    'id' => 'help',
                    'label' => 'Instrukcja Obsługi portalu',
                    'href' => '/pomoc',
                    'icon' => 'icon-applications-kto_tu_rzadz'
                ),
            )
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny();
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

        foreach($items as $i => $item) {

            if(isset($item['submenu'])) {
                $items[$i]['submenu']['selected'] = $this->chapter_submenu_selected;
            }

        }


        $output = array(
            'items' => $items,
            'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
        );

        return $output;

    }

}
