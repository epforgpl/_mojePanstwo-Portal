<?php

App::uses('StartAppController', 'Start.Controller');

class CollectionsController extends StartAppController {

    public $chapter_selected = 'collections';

    public function index() {
        $this->title = 'Moje Kolekcje';

        $this->loadDatasetBrowser('kolekcje', array(
            'conditions' => array(
                'dataset' => 'kolekcje',
                'kolekcje.user_id' => $this->Auth->user('id'),
            ),
            'aggsPreset' => null,
            'aggs' => array_merge(array(), $this->getChaptersAggs()),
            'beforeBrowserElement' => 'Start.kolekcje',
        ));
    }

}
