<?php

App::uses('ApplicationsController', 'Controller');

class StartController extends ApplicationsController
{

	public $settings = array(
        'id' => '',
        'title' => 'mojePaństwo',
        'shortTitle' => 'mojePaństwo',
        'subtitle' => '',
    );

	public function help() {

	}

	public function view()
    {

        $options = array(
            'searchTag' => array(
	            'href' => '/krs',
	            'label' => 'KRS',
            ),
            'autocompletion' => array(
                'dataset' => 'krs_podmioty,krs_osoby',
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Start',
                    'element' => 'cover',
                ),
                'aggs' => array(
                ),
            ),
            'apps' => true,
            'browserTitle' => 'Wyniki wyszukiwania:',
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->title = 'mojePaństwo';
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }

    public function getChapters()
    {

        return array(
		    'items' => array(
			    array(
				    'id' => 'powiadomienia',
				    'label' => 'Moje powiadomienia',
                    'icon' => 'icon-applications-powiadomienia',
				    'href' => 'moje-powiadomienia',
			    ),
			    array(
				    'id' => 'pisma',
				    'label' => 'Moje pisma',
                    'icon' => 'icon-datasets-pisma',
				    'href' => 'moje-pisma',
			    ),
			    array(
				    'id' => 'kolekcje',
				    'label' => 'Moje kolekcje',
                    'icon' => 'glyphicon glyphicon-folder-open',
				    'href' => 'moje-kolekcje',
			    ),
			    array(
				    'id' => 'konto',
				    'label' => 'Ustawienia konta',
                    'icon' => 'icon-datasets-users',
				    'href' => 'konto',
			    ),
			    array(
				    'id' => 'strony',
				    'label' => 'Strony, którymi zarządzam',
                    'icon' => 'icon-datasets-strony',
				    'href' => 'moje-strony',
			    ),
		    ),
	    );

    }

}
