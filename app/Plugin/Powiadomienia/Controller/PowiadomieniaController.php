<?php

App::uses('ApplicationsController', 'Controller');

class PowiadomieniaController extends ApplicationsController
{

    public $settings = array(
        'id' => 'powiadomienia',
        'title' => 'Powiadomienia',
        'subtitle' => 'Obserwuj interesujące Cię dane publiczne',
    );

    public $_layout = array(
        'header' => array(
            'element' => 'app',
        ),
        'body' => array(
            'theme' => 'default',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );

    public $components = array('Paginator');
    public $uses = array('Dane.Dataobject');
    public $helpers = array('Dane.Dataobject');

    public $appSelected = 'powiadomienia';

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/powiadomienia/img/social/powiadomienia.jpg');
    }

    public function view()
    {
		
		if( !$this->Auth->user() ) {
			
			return $this->render('login');
			
		}
		
        $this->setMenuSelected();

        $subs = $this->Dataobject->find('all', array(
            'conditions' => array(
                'subscribtions' => true,
            ),
            'limit' => 50,
        ));


        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'conditions' => array(),
            'feed' => 'user',
            'order' => 'date desc',
        );

        if (isset($this->request->query['q']))
            $this->Paginator->settings['conditions'] = array(
                'q' => $this->request->query['q'],
            );

        $hits = $this->Paginator->paginate('Dataobject');

        $dataFeed = array(
            'hits' => $hits,
            'took' => $this->Dataobject->getPerformance(),
            // 'preset' => $this->settings['preset'],
            'searchTitle' => 'moich powiadomieniach',
        );

        $this->set('dataFeed', $dataFeed);
        $this->set('subs', $subs);
        $this->title = 'Powiadomienia';
        $this->setMenuSelected('obserwuje_powiadomienia');
    }

    public function jak_to_dziala()
    {
        $this->title = 'Jak to działa? - Powiadomienia';
        $this->setMenuSelected('jak_to_dziala');

        if ($this->domainMode == "PK")
            $this->render('Powiadomienia/pk-jak_to_dziala');
    }

    public function getMenu()
    {

        $menu = array(
            'items' => array(
                array(
                    'label' => 'Powiadomienia',
                ),
            ),
            'base' => '/powiadomienia',
        );

    }

} 