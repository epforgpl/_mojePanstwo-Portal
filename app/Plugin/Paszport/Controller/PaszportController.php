<?php

App::uses('ApplicationsController', 'Controller');
App::import('Model', 'Paszport.User');
App::uses('Security', 'Utility');

class PaszportController extends ApplicationsController
{
    public $settings = array(
        'id' => 'paszport'
    );

    public function beforeRender()
    {

        if ($this->Auth->loggedIn()) {
            $this->settings['menu'] = array(
                array(
                    'id' => '',
                    'label' => 'Profil',
                    'href' => 'paszport'
                ),
            );
        }

        parent::beforeRender();
    }

    public function getMenu()
    {
        $menu = array(
            'items' => array(),
            'base' => '/' . $this->settings['id'],
        );

        $menu['items'][] = array(
            'label' => 'Podstawowe informacje',
            'id' => '',
        );

        $menu['items'][] = array(
            'label' => 'Aplikacje API',
            'id' => 'api_apps',
        );

        return $menu;
    }

    public function profile()
    {
        if ($this->Auth->loggedIn()) {
            $user = $this->Auth->User();
            $this->set('user', $user);

            $user = new User();
            $this->set('canCreatePassword', $user->canCreatePassword());
        } else {
            $this->redirect(array('action' => 'login'));
        }
    }

    public function keys()
    {

    }

    public function logs()
    {

    }

    public function forgot()
    {
        $this->setLayout(array(
            'header' => array(
	            'element' => 'main',
            ),
            'body' => array(
                'theme' => 'wallpaper',
            )
        ));
        if ($this->request->isPost()) {
            if (isset($this->request->data['User']['password'])) {

                $user = new User();
                $response = $user->forgotNewPassword($this->data);

                if (isset($response['errors']) && is_array($response['errors']) && count($response['errors']) > 0) {

                    foreach ($response['errors'] as $field => $error) {
                        $this->Session->setFlash(__d('paszport', $error, true), null, array('class' => 'alert-danger'));
                    }

                } elseif (isset($response['success']) && $response['success']) {
                    $this->set('tokenSuccess', true);
                    $this->set('newPasswordSuccess', true);
                } else {
                    throw new BadRequestException();
                }

            } else {
                $user = new User();
                $response = $user->forgot($this->data);

                if (isset($response['errors']) && is_array($response['errors']) && count($response['errors']) > 0) {

                    foreach ($response['errors'] as $field => $error) {
                        $this->Session->setFlash(__d('paszport', $error, true), null, array('class' => 'alert-danger'));
                    }

                } elseif (isset($response['success']) && $response['success']) {
                    $this->set('success', true);
                } else {
                    throw new BadRequestException();
                }
            }
        } else {
            if (isset($this->request->query['token'])) {
                $user = new User();
                $response = $user->forgotToken(array(
                    'token' => $this->request->query['token']
                ));
                if (isset($response['errors']) && is_array($response['errors']) && count($response['errors']) > 0) {
                    foreach ($response['errors'] as $field => $error) {
                        $this->Session->setFlash(__d('paszport', $error, true), null, array('class' => 'alert-danger'));
                    }
                } elseif (isset($response['success']) && $response['success']) {
                    $this->set('token', $this->request->query['token']);
                    $this->set('tokenSuccess', true);
                } else {
                    throw new BadRequestException();
                }
            }
        }
    }

    public function facebookLogin()
    {
        $this->saveRefererUrl();
        $userId = $this->Connect->FB->getUser();
        if (!$userId) {
            if (isset($this->request->query['error_reason'])) {
                $reason = $this->request->query['error_reason'];
                if ($reason == 'user_denied') {
                    $error = 'LC_PASZPORT_FACEBOOK_LOGIN_USER_DENIED';
                } else {
                    $error = 'LC_PASZPORT_FACEBOOK_LOGIN_FAILED';
                }

                $this->Session->setFlash(__d('paszport', $error, true), null, array('class' => 'alert-error'));
                $this->redirect(array('action' => 'login'));
            }
            $this->redirect($this->Connect->FB->getLoginUrl(array('scope' => 'email')));
        } else {
            $userData = $this->Connect->FB->api('/me/?fields=id,first_name,last_name,email,gender,picture.type(square).width(200),locale');
            if (!$userData)
                $this->redirect($this->Connect->FB->getLoginUrl(array('scope' => 'email')));

            $user = new User();
            $response = $user->registerFromFacebook($userData);

            if (isset($response['errors']) && is_array($response['errors']) && count($response['errors']) > 0) {
                foreach ($response['errors'] as $field => $error) {
                    $this->Session->setFlash(__($error[0]), null, array('class' => 'alert-error'));
                }
            } elseif (isset($response['user']) && $response['user']) {
                // dostosowanie danych do takiego samego formatu który jest zwracany
                // podczas logowania przez formularz
                $user = $response['user']['User'];
                foreach ($response['user'] as $model => $values) {
                    if ($model != 'User')
                        $user[$model] = $values;
                }

                if(strtotime($user['created']) >= time() - 180) {
                    $this->Session->setFlash(
                        'Welcome',
                        'flash_facebook_welcome',
                        array(
                            'plugin' => 'Start',
                            'clean' => true
                        )
                    );
                }

                $this->Auth->login($user);
                $this->redirect($this->Auth->redirectUrl());
            } else {
                throw new BadRequestException();
            }
        }
    }

    private function saveRefererUrl() {
        if (!$this->Session->check('Auth.redirect')) {
            $ref = $this->request->referer();
            if ($ref != Router::url(null, true)) {
                $this->Auth->redirectUrl($ref);
            }
        }
    }

	public function beforeFilter()
	{
		return $this->redirect('/');
	}
	
    public function login()
    {
        $this->setLayout(array(
            'header' => array(
	            'element' => 'main',
            ),
            'body' => array(
                'theme' => 'wallpaper',
            )
        ));
        $this->setMenuSelected();

        if ($this->Auth->loggedIn()) {
            $this->redirect(array(
                'action' => 'profile'
            ));
        } else {
            $this->saveRefererUrl();
            if ($this->request->is('post')) {
                try {
                    $previous_session_id = session_id();
                    $this->Auth->login();
                    $this->Session->write('previous_id', $previous_session_id);

                    $user_id = $this->Auth->user('id');
                    $crossdomain_login_token_plain = rand(0, PHP_INT_MAX) . ' ' . $user_id . ' ' .
                        CROSSDOMAIN_salt;
                    $crossdomain_login_token = urlencode(base64_encode(Security::rijndael($crossdomain_login_token_plain,
                        Configure::read('Security.salt'), 'encrypt')));

                    $this->Session->write('crossdomain_login_token', $crossdomain_login_token);

                    // redirect where it's best depending on the context
                    $this->redirect($this->Auth->redirectUrl());

                } catch (Exception $e) {
                    $this->Session->setFlash(__($e->getMessage()), null, array('class' => 'alert-danger'));
                }
            }

            $this->title = 'Zaloguj się - Konto';

        }
    }

    public function register()
    {

        if( $this->Auth->user() ) {
		    return $this->redirect('/');
	    }

        $this->setLayout(array(
            'header' => array(
	            'element' => 'main',
            ),
            'body' => array(
                'theme' => 'wallpaper',
            )
        ));
        if ($this->request->isPost()) {

            $user = new User();
            $response = $user->register($this->data);

            if (isset($response['errors']) && is_array($response['errors']) && count($response['errors']) > 0) {

                foreach ($response['errors'] as $field => $error) {
                    $this->Session->setFlash(__($error[0]), null, array('class' => 'alert-danger'));
                }

            } elseif (isset($response['user']) && $response['user']) {

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

        foreach ($groups['group'] as &$group)
            $group = __d('paszport', $group, true);

        $this->set('languages', $languages['language']);
        $this->set('groups', $groups['group']);
        $this->title = 'Zarejestruj się - Konto';
    }

    public function cross_domain_login()
    {
        $tokeno = $this->request->query['token'];
        $token = base64_decode($tokeno);
        $token = Security::rijndael($token, Configure::read('Security.salt'), 'decrypt');
        $token = explode(' ', $token);
        if (count($token) != 3 or $token[2] != CROSSDOMAIN_salt) {
            throw new BadRequestException();
        }

        $uid = $token[1];

        if ($this->Auth->loggedIn()) {
            // logout if different user
            if ($this->Auth->user('id') != $uid) {
                $this->Auth->logout();
            }
        }

        $userCl = new User();
        $user = $userCl->read($uid);

        if (empty($user)) {
            throw new Exception("Was expecting user data");
        }

        // login this user
        $this->Auth->login($user);

        // no view
        $this->layout = 'ajax';
        $this->render(false);
    }

    public function cross_domain_logout()
    {
        // logout this user
        $this->Auth->logout();

        // no view
        $this->layout = 'ajax';
        $this->render(false);
    }
}
