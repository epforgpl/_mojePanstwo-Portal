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

    public function facebookLogin()
    {
        $user = $this->Connect->FB->getUser();

        if(!$user)
        {
            if(isset($this->request->query['error_reason']))
            {
                $reason = $this->request->query['error_reason'];
                if($reason == 'user_denied') {
                    $error = 'LC_PASZPORT_FACEBOOK_LOGIN_USER_DENIED';
                } else {
                    $error = 'LC_PASZPORT_FACEBOOK_LOGIN_FAILED';
                }

                $this->Session->setFlash(
                    __d('paszport', $error, true), null,
                    array('class' => 'alert-error')
                );

                $this->redirect(array('action' => 'login'));
            }

            $redirect = $this->Connect->FB->getLoginUrl(
                array('scope' => 'email,user_birthday')
            );

            $this->redirect($redirect);

        } else {
            var_dump($user);
            die();
        }
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
	                
	                $previous_session_id = session_id();	                
                    $this->Auth->login();
	                $this->Session->write('previous_id', $previous_session_id);
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