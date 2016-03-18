<?php

App::uses('StartAppController', 'Start.Controller');

class AlertsController extends StartAppController {

    public $chapter_selected = 'subscriptions';
    public $appSelected = 'powiadomienia';

    public function index() {

		$this->title = 'Moje powiadomienia';

        $options = array(
            'feed' => 'user',
            'order' => 'date desc',
        );

        $this->Components->load('Dane.DataBrowser', $options);

    }

    public function subscriptions() {

		$this->title = 'Sprawy, które obserwuję';

        $options = array(
	        'browserTitle' => 'Sprawy, które obserwuję:',
            'conditions' => array(
	            'subscribtions' => true,
            ),
            'order' => 'date desc',
        );

        $this->Components->load('Dane.DataBrowser', $options);

    }

}
