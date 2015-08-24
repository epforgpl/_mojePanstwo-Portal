<?php

App::uses('DataobjectsController', 'Dane.Controller');

class TwitterAccountsController extends DataobjectsController
{

    public $components = array(
        'RequestHandler',
    );
    public $uses = array('Dane.Dataobject');

    public $menu = array();
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array(),
    );

    public function view()
    {

        $this->addInitLayers(array('powiazania'));
        $this->load();
        
        if(
	        ( $page = $this->object->getLayer('page') ) && 
	        ( $page['logo'] )
        ) {
	        
        } else {
	        	        
	        $this->object->layers['page'] = array(
		        'cover' => false,
		        'logo' => str_replace('_normal', '', $this->object->getData('profile_image_url_https')),
	        );
	         
        }

        $powiazania = $this->object->loadLayer('powiazania');

        if (
            isset($powiazania['posel_id']) &&
            $powiazania['posel_id']
        ) {

            return $this->redirect('/dane/poslowie/' . $powiazania['posel_id'] . '/twitter');

        }

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'twitter',
                'twitter.twitter_account_id' => $this->object->getId(),
            ),
        ));
        // $this->set('DataBrowserTitle', 'Grupy wskaźników w tej kategorii');
        $this->render('Dane.DataBrowser/browser');

    }

} 