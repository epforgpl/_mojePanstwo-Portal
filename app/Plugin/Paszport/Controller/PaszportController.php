<?php

App::uses('ApplicationsController', 'Controller');
App::import('Model', 'Paszport.User');

class PaszportController extends ApplicationsController
{
	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Zaloguj',
                'href' => 'paszport'
			),
			array(
				'id' => 'register',
				'label' => 'Zarejestruj',
                'href' => 'register'
			),
		),
		'title' => 'Paszport',
		'subtitle' => '',
		'headerImg' => 'paszport',
	);

    public function beforeRender() {        
        
        if($this->Auth->loggedIn()) {
            $this->settings['menu'] = array(
                array(
                    'id' => '',
                    'label' => 'Profil',
                    'href' => 'paszport'
                ),
                /*
                array(
                    'id' => 'keys',
                    'label' => 'Klucze API',
                    'href' => 'paszport/klucze'
                ),
                array(
                    'id' => 'logs',
                    'label' => 'Logi',
                    'href' => 'paszport/logi'
                )
                */
            );

        }
        
        parent::beforeRender();
    }

    public function keys()
    {

    }

    public function logs()
    {

    }

    public function login()
    {
	    
        $this->setMenuSelected();
		
        if($this->Auth->loggedIn()) {
            
            $this->set('user', $this->Auth->user());
            $this->render('Paszport/profile');
            
        } else {
	        
            if ($this->request->is('post')) {
                try {
                    $this->Auth->login();
                    $this->redirect($this->referer());
                } catch (Exception $e) {
                    $this->Session->setFlash(
                        __($e->getMessage()),
                        'default',
                        array(),
                        'auth'
                    );
                }
            }
            
            $this->title = 'Zaloguj się - Paszport';
            
        }
    }

    public function register()
    {
        if($this->request->isPost()) {
            
            $user = new User();
            $response = $user->register($this->data);
            
            if(isset($response['errors']) && is_array($response['errors']) && count($response['errors']) > 0) {
                
                foreach($response['errors'] as $field => $error) {
                    $this->Session->setFlash(
                        __($error[0]),
                        'default',
                        array(),
                        'auth'
                    );
                }
                
            } elseif(isset($response['user']) && $response['user']) {
				                 
                $this->Auth->login($response['user']);
                $this->redirect($this->Auth->redirectUrl());
                 
            } else {
                throw new BadRequestException();
            }
        }

        $languages = array(
            'language' => array(
                'Polski',
                'English'
            )
        );

        $groups = array(
            'group' => array(
                'LC_PERSONAL',
                'LC_INSTITUTION'
            )
        );

        foreach($groups['group'] as &$group)
            $group = __d('paszport', $group, true);

        $this->set('languages', $languages['language']);
        $this->set('groups', $groups['group']);
        $this->title = 'Zarejestruj się - Paszport';
    }

} 