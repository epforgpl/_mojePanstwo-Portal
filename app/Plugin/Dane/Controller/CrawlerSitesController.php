<?php

App::uses('DataobjectsController', 'Dane.Controller');

class CrawlerSitesController extends DataobjectsController
{

    public $components = array(
        'RequestHandler',
    );
    public $uses = array('Dane.Dataobject');

    public $menu = array();

    public function view()
    {


        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'crawlerSites.pages:' . $this->object->getId(),
            'dataset' => 'crawler_pages',
            'title' => 'Strony w tym portalu',
            'excludeFilters' => array(
                'site_id',
            ),
        ));

    }

} 