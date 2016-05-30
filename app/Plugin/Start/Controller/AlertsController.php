<?php

App::uses('StartAppController', 'Start.Controller');

class AlertsController extends StartAppController {

    public $chapter_selected = 'subscriptions';
    public $appSelected = 'powiadomienia';

    public function index() {
				
		$this->title = 'Moje powiadomienia';
      
        $this->Components->load('Dane.DataFeed', array(
	        'feed' => 'user',
            'searchTitle' => 'Szukaj w moich powiadomieniach...',
            'timeline' => true,
            'order' => 'date desc',
            'preset' => 'user',
            'limit' => 50,
        ));
        
        $this->render('index');

    }

    public function subscriptions() {
				
		$this->title = 'Sprawy, które obserwuję';

        $options = array(
            'conditions' => array(
	            'subscribtions' => true,
            ),
            'order' => 'date desc',
        );

        $this->Components->load('Dane.DataBrowser', $options);

    }

}
