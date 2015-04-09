<?php
App::uses('HttpSocket', 'Network/Http');
App::import('Model', 'Paszport.User');
/**
 * Class UsersController
 *
 *
 */
class UsersController extends PaszportAppController
{
    public $components = array(
        'Paszport.Image2',
    );

    public $uses = array('Paszport.User');

    /**
     * Sets permissions
     */
    public function beforeFilter()
    {
        // save login redirect because it will be overwritten by AppController::beforeFilter
        if ($this->Session->read("Auth.loginRedirect") != Router::url(array('action' => 'login'), true)
            && $this->Session->read("Auth.loginRedirect") != Router::url(array('action' => 'fblogin'), true)
            && $this->Session->read("Auth.loginRedirect") != (Router::url('/', true) . 'oauth/login')
        ) {
            $this->Auth->loginRedirect = $this->Session->read("Auth.loginRedirect");
        }

        parent::beforeFilter();

        $this->Auth->allow(array(
            'login',
            'add',
            'gate',
            'ping',
            'forgot',
            'reset',
            'fblogin',
            'externalgate',
            'import',
            'externalfblogin',
            'twitterlogin',
            'twitter',
            'client'
        ));
        $this->OAuth->deny('me');
    }

    /**
     * Main view for user
     */
    public function index()
    {
        $id = $this->Auth->user('id');
        $this->layout = 'Paszport.default';
        $user = $this->PassportApi->find('users', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        $user = $user['user'];
        $languages = $this->PassportApi->findAsList('languages', array(
            'fields' => array(
                'Language.id',
                'Language.label'
            )
        ));
        $languages = $languages['language'];
        if (!$user['User']['password_set'] && !is_null($user['User']['source'])) {
            $this->Session->setFlash('<a href="' . Router::url(array(
                    'controller' => 'users',
                    'action' => 'setpassword'
                )) . '">' . __d('paszport', 'LC_PASZPORT_SUGGEST_SETTING_PASSWORD', true) . '</a>', null, array('class' => 'alert-info'));
        }
        $this->data = $user;
        $this->set(compact('languages'));
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_ACCOUNT_INFO', true));
    }

    /**
     * Login method
     */
    public function login()
    {
        if ($this->Auth->loggedIn()) {
            $this->redirect('/');
        }

        if ($this->request->is('post')) {
            $user = $this->PassportApi->User()->login($this->data);

            if ($user['user']) {
	            $this->Session->write('previous_id', session_id());
                $this->Auth->login($user['user']);
                $this->redirect($this->Auth->redirectUrl());

            } else {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_LOGIN_FAILED'), 'alert', array('class' => 'alert-error'), 'auth');
                $this->redirect(array('action' => 'login'));
            }
        }
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_LOGIN', true));

    }

    /**
     * Performs a FB login
     */
    public function fblogin()
    {
        $fb_user = $this->Connect->FB->getUser();
        if (!$fb_user) {
            if (isset($this->request->query['error_reason'])) {
                // an error has occurred
                //fblogin?error=access_denied&error_code=200&error_description=Permissions+error&error_reason=user_denied&state=dca62b8eb289375be97d4783b4caedc4
                $error = $this->request->query['error'];
                $error_code = $this->request->query['error_code'];
                $error_description = $this->request->query['error_description'];
                $error_reason = $this->request->query['error_reason'];

                if ($error_reason == 'user_denied') {
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FACEBOOK_LOGIN_USER_DENIED', true), null, array('class' => 'alert-error'));
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FACEBOOK_LOGIN_FAILED', true), null, array('class' => 'alert-error'));
                    $this->redirect(array('action' => 'login'));
                }

            } else {
                $this->redirect($this->Connect->FB->getLoginUrl(array('scope' => 'email,user_birthday')));
            }
        } else { # we do have access to user details
            $user_data = $this->Connect->FB->api('/me/?fields=id,first_name,last_name,email,gender,picture.type(square).width(200),birthday,locale');
            if ($user_data == null) {
                $this->redirect($this->Connect->FB->getLoginUrl(array('scope' => 'email,user_birthday')));
            }

            /* $conds = array(
                'conditions' => array(
                    'OR' => array(
                        array('User.facebook_id' => $user_data['id']),
                        array('User.email' => $user_data['email'])
                    ),
                ),
                'contain' => array('Language', 'Group', 'UserExpand'),
            ); */

            // Fatal Error (1): Call to a member function find() on a non-object in [/home/www/portal-v2/_mojePanstwo-Portal/app/Plugin/Paszport/Controller/UsersController.php, line 145]
            // Trzeba wszystkie wywołania $this->PaszportApi zmienić na odwołania do nowego API przez model User
            $_user = new User();
            $user = $_user->findFacebookUser($user_data['id'], $user_data['email']);
            if (!isset($user['user']) || empty($user['user'])) {
                $user = false;
            }
            if ($user && $user['user']['facebook_id']) { # if user is already FB connected to us, just log him in
                //$user['user']['password'] = md5($user_data['id'] . $user_data['email']);
                $this->Auth->login($user['user']);
                $this->_log(array(
                    'msg' => 'LC_PASZPORT_LOG_LOGIN_FB',
                    'ip' => $this->request->clientIp(),
                    'user_agent' => env('HTTP_USER_AGENT')
                ));
                if ($this->Session->read('API.gate')) {
                    $service = $this->Session->read('API.service');
                    $session = $this->Session->read('API.session');
                    $this->externalgate($service, $session);
                }

                $this->redirect($this->Auth->redirectUrl());

            } else { # if not we will attempt to create new user based on his facebook data or we will merge his existing account
                if ($user && $user['User']['email']) { # merge attempt
                    $this->User->id = $user['User']['id'];
                    $this->PassportApi->field('users', $user['User']['id'], array('User' => array('facebook_id' => $user_data['id'])));
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FB_ACCOUNT_MERGED', true), 'alert', array('class' => 'alert-success'));
                    $this->Auth->login($user['User']);
                    if ($this->Session->read('API.gate')) {
                        $service = $this->Session->read('API.service');
                        $session = $this->Session->read('API.session');
                        $this->externalgate($service, $session);
                    }
                    $this->redirect(array('action' => 'index')); // show profile for user to verify it

                } else { # new user
                    $to_save = array(
                        'User' => array(
                            'personal_name' => $user_data['first_name'],
                            'personal_lastname' => $user_data['last_name'],
                            'username' => $user_data['first_name'] . '' . $user_data['last_name'] . rand(0, 999),
                            'email' => $user_data['email'],
                            'password' => $this->Auth->password(md5($user_data['id'] . $user_data['email'])),
                            'repassword' => $this->Auth->password(md5($user_data['id'] . $user_data['email'])),
                            'facebook_id' => (int)$user_data['id'],
                            'personal_bday' => date('Y-m-d', strtotime($user_data['birthday'])),
                            'personal_gender' => $this->__fbGender($user_data['gender']),
                            'language_id' => $this->__fbLanguage($user_data['locale']),
                            'photo' => preg_replace('/https/', 'http', $user_data['picture']['data']['url']),
                            'source' => 'facebook',
                            'group_id' => 1, # personal group
                        )
                    );

                    $resp_user = $_user->register($to_save);
                    if (array_key_exists('user', $resp_user) && !empty($resp_user['user'])) {
                        $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FACEBOOK_REGISTER', true), null, array('class' => 'alert-success'));

                        $this->Auth->login($resp_user['user']);
                        $this->Session->write('FB_JUST_REGISTERED', true);
                        if ($this->Session->read('API.gate')) {
                            $service = $this->Session->read('API.service');
                            $session = $this->Session->read('API.session');
                            $this->externalgate($service, $session);
                        }
                        $this->redirect(array('action' => 'login'));

                    } else {
                        $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FACEBOOK_REGISTER_FAILED', true), null, array('class' => 'alert-error'));
                        $this->redirect(array('action' => 'login'));
                    }

                }
            }
        }
    }

    /**
     *
     */
    public function externalgate($service = null, $session_id = null, $ajax = null)
    {

        if (is_null($service) || is_null($session_id)) {
            if ($ajax) {
                $this->data = array('status' => 500, 'error' => 4, 'response' => 'Not enough params');
            } else {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_GATE_FAILURE', true), 'alert', array('class' => 'alert-error'));
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
        }
        if ($this->request->isPost()) {
            $this->Session->write('API', array('gate' => 1, 'service' => $service, 'session' => $session_id));
        }
        # is he logged on some other service
        if ($this->Auth->loggedIn()) {
            $service_exists = $this->PassportApi->find('services', array(
                'conditions' => array('Service.checksum' => $service),
                'contain' => array()
            ));
            $service_exists = count($service_exists['service']);
            if ($service_exists < 1) {
                if ($ajax) {
                    $this->data = array('status' => 500, 'error' => 3, 'response' => 'Service not found');
                } else {
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_GATE_FAILURE', true), 'alert', array('class' => 'alert-error'));
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }

                return false;
            }
            $user = $this->PassportApi->find('users', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id'),
                ),
                'contain' => array(
                    'Service' => array(
                        'fields' => array('Service.id', 'Service.callback_url', 'Service.salt'),
                        'conditions' => array('Service.checksum' => $service),
                    ),
                    'UserExpand',
                ),
            ));
            $user = $user['user'];

            if (!$user['Service']) { # the user does not have profile on given service
                $this->loadModel('ServiceUser');
                $service_to_add = $this->PassportApi->find('services', 'find', array(
                    'recursive' => -2,
                    'conditions' => array('checksum' => $service)
                ));
                $this->PassportApi->add('serviceusers', array(
                    'user_id' => $user['User']['id'],
                    'service_id' => $service_to_add['Service']['id'],
                ));
                $user['Service'][0] = $service_to_add['Service'];
            }
            $this->loadModel('ServiceUser');
            if ($user['User']['photo']) {
                $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
            } else {
                $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
            }
            $user_data_to_pass = array(
                'id' => $user['User']['id'],
                'email' => $user['User']['email'],
                'personal_name' => (isset($user['User']['personal_name'])) ? $user['User']['personal_name'] : '',
                'personal_lastname' => (isset($user['User']['personal_lastname'])) ? $user['User']['personal_lastname'] : '',
                'avatar' => $avatar,
                'username' => $user['User']['username'],
            );
            $token = $this->createtoken($session_id, $user['Service'][0]['salt'], array(
                'expires' => strtotime('+2 minutes'),
                'user' => $user_data_to_pass
            ));
            $callback_url = null;
            if (isset($this->request->query['callback'])) {
                $callback_url = '&return_url=' . urlencode($this->request->query['callback']);
            }
            if ($this->Session->read('API.gate') == 1) {
                $this->Session->delete('API');
                $this->redirect($user['Service'][0]['callback_url'] . '/?token=' . urlencode($token) . $callback_url);
            }
            $this->data = array(
                'status' => '200',
                'error' => '0',
                'response' => $user['Service'][0]['callback_url'] . '/?token=' . urlencode($token) . $callback_url
            );
            echo trim(json_encode($this->data));
            die();
        }
        if ($this->request->isPost() && isset($this->data['User']['email']) && isset($this->data['User']['password'])) {
            $service_exists = $this->PassportApi->find('services', array(
                'conditions' => array('Service.checksum' => $service),
                'contain' => array()
            ));
            $service_exists = count($service_exists['service']);
            if ($service_exists < 1) {
                if ($ajax) {
                    $this->data = array('status' => 500, 'error' => 3, 'response' => 'Service not found');
                } else {
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_GATE_FAILURE', true), 'alert', array('class' => 'alert-error'));
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }

                return false;
            }
            $login = $this->PassportApi->User()->login($this->data);
            $login = $login['user'];
            if ($login) {
                $user = $this->PassportApi->find('users', array(
                    'conditions' => array(
                        'User.email' => $this->data['User']['email'],
                    ),
                    'contain' => array(
                        'Service' => array(
                            'fields' => array('Service.id', 'Service.callback_url', 'Service.salt'),
                            'conditions' => array('Service.checksum' => $service),
                        ),
                        'UserExpand',
                    ),
                ));
            }
            $user = $user['user'];
            if ($user) {
                # proper authorization
                if (!$user['Service']) { # the user does not have profile on given service
                    $this->loadModel('ServiceUser');
                    $service_to_add = $this->PassportApi->find('users', array(
                        'recursive' => -2,
                        'conditions' => array('checksum' => $service)
                    ));
                    $this->PassportApi->add('serviceusers', array(
                        'user_id' => $user['User']['id'],
                        'service_id' => $service_to_add['Service']['id'],
                    ));
                    $user['Service'][0] = $service_to_add['Service'];
                }
                if ($user['User']['photo_small']) {
                    $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
                } else {
                    $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
                }
                $user_data_to_pass = array(
                    'id' => $user['User']['id'],
                    'email' => $user['User']['email'],
//                    'personal_name' => $user['User']['personal_name'],
//                    'personal_lastname' => $user['User']['personal_lastname'],
                    'avatar' => $avatar,
                    'username' => $user['User']['username'],
                );
                # save last login
                $this->loadModel('ServiceUser');
                $token = $this->createtoken($session_id, $user['Service'][0]['salt'], array(
                    'expires' => strtotime('+2 minutes'),
                    'user' => $user_data_to_pass
                ));
                $this->Auth->login($user['User']);
                $this->Session->write('UserData', $user_data_to_pass);
                $callback_url = null;
                if (isset($this->request->query['callback'])) {
                    $callback_url = '&return_url=' . urlencode($this->request->query['callback']);
                }
                if ($ajax) {
                    $this->data = array(
                        'status' => 200,
                        'error' => 0,
                        'response' => $user['Service'][0]['callback_url'] . '/?token=' . urlencode($token) . $callback_url
                    );
                } else {
                    $this->redirect($user['Service'][0]['callback_url'] . '/?token=' . urlencode($token) . $callback_url);
                }
            } else {
                if ($ajax) {
                    $this->data = array('status' => 500, 'error' => 2, 'response' => 'User not found');
                } else {
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_PASSWORD_INCORRECT', true), 'alert', array('class' => 'alert-error'));
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
            }
        } else {
            $this->data = array('status' => 500, 'error' => 1, 'response' => null);
            echo json_encode($this->data);
            exit();
        }
    }

    /**
     * Creates a token using the encryption library
     * @see Vendor/Encrypt.php
     *
     * @param $session_id
     * @param $service_salt
     * @param string|null $data
     *
     * @return string
     */
    protected function createtoken($session_id, $service_salt, $data = null)
    {
        $key = md5($session_id . $service_salt);
        $e = new Encryption(MCRYPT_BlOWFISH, MCRYPT_MODE_CBC);
        $encryptedData = $e->encrypt(is_null($data) ? strtotime('+2 minutes') : json_encode($data), $key);

        return base64_encode($encryptedData);
    }

    /**
     *
     * Converts FB male|female to our int representatives
     *
     * @param string $gender
     *
     * @return int
     */
    public function __fbGender($gender)
    {
        switch ($gender) {
            case "male":
                return 1;
                break;
            case "female":
                return 2;
                break;
            default:
                return 0;
                break;
        }
    }

    /**
     * Converts rfc language definitions country_LOCALE into our models
     *
     * @param string $rfc_lang
     *
     * @return int
     */
    public function __fbLanguage($rfc_lang)
    {
        /*$lang = $this->PassportApi->find('languages', array('conditions' => array('rfc_code' => $rfc_lang)));
        $lang = $lang['lang'];
        if ($lang) {
            return $lang['Language']['id'];
        } else {
            return 2; # english
        }*/
        return 2;
    }

    /**
     * forces password for just registered FB users
     */
    public function setpassword()
    {
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_SET_PASSWORD', true));

        $user = $this->PassportApi->find('users', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        $user = $user['user'];
        if ($user['User']['password_set']) {
            $this->redirect(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $response = $this->PassportApi->User()->setPassword($this->data);

            if (isset($response['errors']['password'])) {
                $this->Session->setFlash(__d('paszport', $response['errors']['password'][0], true), 'alert', array('class' => 'alert-error'));

            } else {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_PASSWORD_SET', true), null, array('class' => 'alert-success'));
                $this->Session->delete('FB_JUST_REGISTERED');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    /**
     * Switcher to attach profiles
     *
     * @param string|null $profile
     */
    public function attachprofile($profile = null)
    {
        if (is_null($profile)) {
            $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_ERROR', true), 'alert', array('class' => 'alert-error'));
            $this->redirect($this->referer(null, true));
        }

        switch ($profile) {
            case "facebook":
                $this->__attachFacebook();
                break;
            case "gplus":
                //@TODO add gplus
                break;

        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * @param bool $deattach - on true deletes the relation
     *
     * @return bool
     */
    public function __attachFacebook($deattach = false, $redirect = null)
    {
        if ($deattach) {
            $this->User->id = $this->Auth->user('id');
            if ($this->PassportApi->deletefield('users', $this->Auth->user('id'), 'facebook_id')) {
//                $this->_log(array('msg' => 'LC_PASZPORT_LOG_FB_DEATTACHED', 'ip' => $this->request->clientIp(), 'user_agent' => env('HTTP_USER_AGENT')));
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FB_DEATTACHED', true), null, array('class' => 'alert-success'));
            }

            return true;
        }
        # check if user has already given permissions to the app
        $user_data = $this->Connect->FB->api('/me/?fields=id,first_name,last_name,email,gender,picture.type(square).width(200),birthday,locale');
        if ($user_data['id']) { # merge, save, inform
            $this->User->id = $this->Auth->user('id');

            $to_save = array(
                'User' => array(
                    'facebook_id' => $user_data['id'],
                ),
            );
            if ($this->PassportApi->field('users', $this->Auth->user('id'), array(
                'facebook_id',
                $user_data['id']
            ))
            ) {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FB_ACCOUNT_MERGED', true), 'alert', array('class' => 'alert-success'));
//                $this->_log(array('msg' => 'LC_PASZPORT_LOG_FB_ACCOUNT_MERGED', 'ip' => $this->request->clientIp(), 'user_agent' => env('HTTP_USER_AGENT')));
            } else {
                $this->Session->setFlash(implode('. ', array_pop($this->User->validationErrors)), 'alert', array('class' => 'alert-error'));
            }
        } else { # fetch permissions try to merge again
            $opts = array('scope' => 'email,user_birthday');
            if (!is_null($redirect)) {
                $opts['redirect'] = $redirect;
            }
            $this->redirect($this->Connect->FB->getLoginUrl($opts));
        }
    }

    /**
     * Switcher to attach profiles
     *
     * @param string|null $profile
     */
    public function deattachprofile($profile = null)
    {
        if (is_null($profile)) {
            $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_ERROR', true), 'alert', array('class' => 'alert-error'));
            $this->redirect($this->referer(null, true));
        }

        switch ($profile) {
            case "facebook":
                $this->__attachFacebook(true);
                break;
            case "gplus":
                //@TODO add gplus
                break;

        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     *
     * Generates token, sends mail, validates token and redirect to password changing method
     * @return bool
     */
    public function forgot()
    {
        App::uses('CakeEmail', 'Network/Email');
        if ($this->request->isPost()) { # if post then someone sent form, we should find user with given e-mail
            $user = $this->PassportApi->find('users', array('conditions' => array('User.email' => $this->data['User']['email'])));
            $user = $user['user'];
            if ($user) { # if user exists send email
                $Email = new CakeEmail('default');
                $Email->to($user['User']['email'])
                    ->template('Paszport.reset')
                    ->emailFormat('text')
                    ->subject(__d('paszport', 'LC_PASZPORT_MAIL_RESET_PASS_SUBJECT', true));

                $e = new Encryption(MCRYPT_BlOWFISH, MCRYPT_MODE_CBC);
                $data = json_encode(array(
                    'email' => $user['User']['email'],
                    'expires' => strtotime('+24 hours')
                ));
                $hash = base64_encode($e->encrypt($data, Configure::read('Security.salt')));
                $Email->viewVars(array('hash' => urlencode($hash)));

                if ($Email->send()) {
//                    $this->_log(array('msg' => 'LC_PASZPORT_LOG_MAIL_RESET_PASS_SENT', 'ip' => $this->request->clientIp(), 'user_agent' => env('HTTP_USER_AGENT')));
                    $this->PassportApi->field('users', $user['User']['id'], array('User' => array('reset_hash' => urlencode($hash))));

                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_MAIL_RESET_PASS_SENT', true), 'alert', array('class' => 'alert-info'));
                    $this->redirect('login');

                } else {
                    $this->Session->setFlash(__('LC_MAIL_SEND_ERROR', true), 'alert', array('class' => 'alert-error'));
                }


            } else { # if not display error
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_USER_DOES_NOT_EXIST', true), 'alert', array('class' => 'alert-error'));
            }
        } else { # if the request was not post
            if (isset($this->request->query['token'])) { # but it has $hash sent, we are going to change user's password
                $hash = $this->request->query['token'];
                $hash = str_replace(' ', '+', urldecode($hash));
                $e = new Encryption(MCRYPT_BlOWFISH, MCRYPT_MODE_CBC);

                $token_data = json_decode($e->decrypt(base64_decode($hash), Configure::read('Security.salt')), true);
                $user_email = $token_data['email'];
                $expires = $token_data['expires'];

                if (time() > $expires) {
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_SECURITY_TOKEN_EXPIRED', true), 'alert', array('class' => 'alert-error'));
                    $this->redirect(array('action' => 'forgot'));

                    return false;

                } else {
                    $user = $this->PassportApi->find('users', array(
                        'conditions' => array(
                            'User.email' => $user_email,
                            'User.reset_hash' => urlencode($this->request->query['token'])
                        )
                    ));
                    $user = $user['user'];
                    if ($user) {
                        $this->Session->write('User.id', $user['User']['id']);
                        $this->redirect(array('action' => 'reset'));
                    } else {
                        $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_SECURITY_TOKEN_INVALID', true), 'alert', array('class' => 'alert-error'));
                    }
                }

            }
        }
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_FORGOT_PASSWORD', true));
    }

    /**
     *
     * Sets password given by user
     * clears the reset_hash field in DB
     */
    public function reset()
    {
        if ($this->request->isPost() && $this->Session->read('User.id')) {
            $to_save = $this->data;
            $to_save['User']['id'] = $this->Session->read('User.id');

            $response = $this->PassportApi->User()->reset($to_save);
            if (isset($response['errors']['password'])) {
                $this->Session->setFlash(__d('paszport', $response['errors']['password'][0], true), 'alert', array('class' => 'alert-error'));

            } else {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_PASSWORD_RESET_SUCCESS'), 'alert', array('class' => 'alert-success'));
                $this->Session->delete('User');
                $this->redirect(array('action' => 'login'));
            }
        }
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_FORGOT_PASSWORD', true));
    }

    /**
     * Logout
     */
    public function logout()
    {
        if ($this->request->isAjax()) {
            $this->requestAction($this->Auth->logout());
            echo json_encode(array(
                'error' => '',
                'status' => 200,
                'msg' => __d('paszport', 'LC_PASZPORT_LOGOUT', true)
            ));
            die();
        }

        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_LOGOUT', true));
        $this->Auth->logout();
        $this->redirect($this->referer());
    }

//    /**
//     * @return string url to avatar
//     */
//
//    public function __fetchUserAvatarLinkFromFB()
//    {
//        $user_data = $user_data = $this->Connect->FB->api('/me/?fields=id,first_name,last_name,email,gender,picture.type(square).width(200),birthday,locale');
//        if (!$user_data) {
//            $this->__attachFacebook(null, FULL_BASE_URL . $this->here);
//        }
//        return preg_replace('/https/', 'http', $user_data['picture']['data']['url']);
//    }

    /**
     * Register
     */
    public function add()
    {
        if($this->request->isPost()) {
            $to_save = $this->data;
            $user = $this->PassportApi->User()->add($to_save);
            if (isset($user['user'])) {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_REGISTRATION_COMPLETE'), 'alert', array('class' => 'alert-success'));
                if ($this->Session->read('App.gatemode')) {
                    $this->redirect(array('action' => 'gate'));
                }
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_REGISTRATION_FAILED'), 'alert', array('class' => 'alert-error'));

                $this->loadModel('Paszport.User');
                $__p = function ($translation_key) {
                    return __d('paszport', $translation_key);
                };

                foreach ($user['errors'] as $key => $err_list) {
                    $this->User->validationErrors[$key] = array_map($__p, $err_list);
                }
            }
        }

        //$languages = $this->PassportApi->findAsList('languages', array('fields' => array('id', 'label')));
        $languages = array(
            'language' => array(
                'Polski',
                'English'
            )
        );

        //$groups = $this->PassportApi->findAsList('groups', array('fields' => array('id', 'label')));
        $groups = array(
            'group' => array(
                'LC_PERSONAL',
                'LC_INSTITUTION'
            )
        );

        foreach($groups['group'] as &$group) {
            $group = __d('paszport', $group, true);
        }

        $this->set('languages', $languages['language']);
        $this->set('groups', $groups['group']);
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_REGISTER', true));
    }


//    /**
//     * @param null $external
//     */
//    public function externalavatar($external = null)
//    {
//        $this->__avatar(null, 'facebook');
//    }

    /**
     * Saves changes to one field in model
     * return json response about success or failure
     */
    public function field()
    {
        $id = $this->Auth->user('id');
        echo json_encode($this->PassportApi->field('users', $id, $this->data));
        exit();
    }

    /**
     * @param null $delete
     */
    public function avatar($delete = null)
    {
        $this->__avatar($delete);
    }

    /**
     * Manage users avatar
     *
     * @param null $delete
     * @param string|null $external
     */
    public function __avatar($delete = null, $external = null)
    {
        $this->User->id = $this->Auth->user('id');
        if (!is_null($delete)) {
            if ($this->PassportApi->deletefield('users', $this->Auth->user('id'), 'photo')) {
                $this->PassportApi->deletefield('users', $this->Auth->user('id'), 'photo_small');
                $user = $this->PassportApi->find('users', array('conditions' => array('User.id' => $this->Auth->user('id'))));
                $this->Auth->login($user['user']['User']);
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_AVATAR_DELETED', true), null, array('class' => 'alert-success'));
            }
            $this->redirect(array('action' => 'index'));
        } else if ($this->request->isPost()) {
            $data = $this->data;
            $data['User']['photo']['binary'] = base64_encode(file_get_contents($this->data['User']['photo']['tmp_name']));
            if ($user = $this->PassportApi->User()->avatar($data)) {
                $this->Session->write('Auth.User', $user['user']);
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_SAVED', true), null, array('class' => 'alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_SAVE_FAILED', true), null, array('class' => 'alert-error'));
            }
        }
        /**  else if (!is_null($external)) {
         * switch ($external) {
         * case "facebook":
         *
         * $this->User->save(array('photo' => $this->__fetchUserAvatarLinkFromFB()));
         * $this->_log(array('msg' => 'LC_PASZPORT_LOG_AVATAR_FB_CHANGED', 'ip' => $this->request->clientIp(), 'user_agent' => env('HTTP_USER_AGENT')));
         * break;
         * default:
         * break;
         * }
         * $this->redirect(array('action' => 'index'));
         * }
         * $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_ACCOUNT_INFO', true)); **/

    }

    /**
     * deletes currently logged acount
     * verifies users based on password he has retyped
     */
    public function delete()
    {
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_ACCOUNT_DELETE_TITLE', true));

        if ($this->request->isPost()) {
            //$id = $this->Auth->user('id');
            //$user = $this->PassportApi->find('users', array('conditions' => array('User.id' => $id)));

            $resp = $this->PassportApi->User()->delete($this->data);

            if (isset($resp['errors'])) {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_ACCOUNT_DELETE_WARNING', true), null, array('class' => 'alert-danger'));
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_PASSWORD_INCORRECT', true), 'alert', array('class' => 'alert-error'));

                return;
            }

            $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_ACCOUNT_DELETED', true), 'alert', array('class' => 'alert-success'));
            $this->Auth->logout();
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    /**
     * Method responsible for acting as a gate for other applications
     * takes session ID on which it will create and send token to corresponding app
     *
     *
     * @param string $session_id - session id from requesting service
     * @param string $service - service name to respond to
     *
     */
    public function gate($session_id = null, $service = null)
    {
        $this->Session->write('App.gatemode', true);
        if (is_null($session_id) || is_null($service)) {
            $this->redirect($this->referer());
        }
        $this->layout = 'gate';
        if ($this->request->isPost()) {
            $user = $this->PassportApi->find('users', array(
                'conditions' => array(
                    'User.email' => $this->data['User']['email'],
                    'User.password' => $this->Auth->password($this->data['User']['password']),
                ),
                'contain' => array(
                    'Service' => array(
                        'fields' => array('Service.id', 'Service.callback_url', 'Service.salt'),
                        'conditions' => array('Service.checksum' => $service),
                    ),
                ),
            ));
            $user = $user['user'];
            if ($user) {
                # proper authorization
                $this->_log(array(
                    'msg' => 'LC_PASZPORT_GATE_AUTHORIZE',
                    'ip' => $this->request->clientIp(),
                    'user_agent' => env('HTTP_USER_AGENT'),
                    'user_id' => $user['User']['id']
                ));
                if (!$user['Service']) { # the user does not have profile on given service
//                    $this->loadModel('ServiceUser');
                    $service_to_add = $this->PassportApi->find('services', array(
                        'recursive' => -2,
                        'conditions' => array('checksum' => $service),
                        'fields' => array('Service.id')
                    ));
                    $service_to_add = $service_to_add['service'];
                    $this->PassportApi->add('serviceusers', array(
                        'user_id' => $user['User']['id'],
                        'service_id' => $service_to_add['Service']['id'],
                    ));
                    $user['Service'][0] = $service_to_add['Service'];
                }

                $token = $this->createtoken($session_id, $user['Service'][0]['salt']);
                # notify the service
                if ($this->notifyService($user['Service'][0]['callback_url'], $token, $user['Service'][0]['salt'])) { # if succed proceed with redirection of the consumer
                    # send over the browser
                    $this->redirect($user['Service'][0]['callback_url'] . '/?token=' . $token);
                } else {
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_GATE_FAILURE', true), 'alert', array('class' => 'alert-error'));
                }
                $this->Session->delete('App.gatemode');
            }
        }
    }

    /**
     * Notifies service about proper authorization
     *
     * @deprecated
     *
     * @param string $service_callback_url
     * @param string $token
     * @param string $service_salt
     *
     * @return bool
     */
    protected function notifyService($service_callback_url, $token, $service_salt)
    {
        //@TODO fix this or remove
        return true;
        $socket = new HttpSocket(array(
            'ssl_verify_peer' => true, //@TODO set to true when the SSL issues on sejmometr will be resolved
        ));
        $e = new Encryption(MCRYPT_BlOWFISH, MCRYPT_MODE_CBC);

        $response = $socket->post($service_callback_url, array(
                'token' => $token,
                'identity' => base64_encode($e->encrypt(Configure::read('Security.salt'), md5($service_salt)))
            )
        );
        if ($response->isOk()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Allows services to ping the SSO with user email and service hash and session id
     * to show where user is logged and when was he's last activity
     *
     * @throws BadRequestException
     * @throws NotImplementedException
     */
    public function ping()
    {
        if ($this->Auth->loggedIn()) {
            echo json_encode(array('status' => '1'));
        } else {
            echo json_encode(array('status' => '0'));
        }
        exit();
    }

    /**
     * Performs a FB login
     */
    public function externalfblogin($service = null, $session_id = null)
    {
        $user_data = $this->Connect->FB->api('/me/?fields=id,first_name,last_name,email,gender,picture.type(square).width(200),birthday,locale');
        if (!isset($user_data['id'])) { # do we have access to user details ?
            $this->redirect($this->Connect->FB->getLoginUrl(array(
                'scope' => 'email,user_birthday',
                'next_url' => FULL_BASE_URL . '/' . $this->here
            )));
        } else { # we do...
            $user = $this->PassportApi->find('users', array(
                'conditions' => array(
                    'OR' => array(
                        array('User.facebook_id' => $user_data['id']),
                        array('User.email' => $user_data['email'])
                    ),
                ),
                'contain' => array('Language', 'Group', 'UserExpand'),
            ));

            $user = $user['user'];
            if ($user && $user['User']['facebook_id']) { # if user is already FB connected to us, just log him in

                $user = $this->PassportApi->find('users', array(
                    'conditions' => array(
                        'User.id' => $user['User']['id'],
                    ),
                    'contain' => array(
                        'Service' => array(
                            'fields' => array('Service.id', 'Service.callback_url', 'Service.salt'),
                            'conditions' => array('Service.checksum' => $service),
                        ),
                        'UserExpand',
                    ),
                ));
                $user = $user['user'];
                if (!$user['Service']) { # the user does not have profile on given service
                    $this->loadModel('ServiceUser');
                    $service_to_add = $this->PassportApi->find('serviceusers', array(
                        'recursive' => -2,
                        'conditions' => array('checksum' => $service)
                    ));
                    $this->PassportApi->add('serviceusers', 'add', array(
                        'user_id' => $user['User']['id'],
                        'service_id' => $service_to_add['Service']['id'],
                    ));
//                    $this->_log(array('msg' => 'LC_PASZPORT_SERVICE_ADDED', 'ip' => $this->request->clientIp(), 'user_agent' => env('HTTP_USER_AGENT')));
                    $user['Service'][0] = $service_to_add['Service'];
                }
                if ($user['User']['photo']) {
                    $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
                } else {
                    $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
                }
                $user_data_to_pass = array(
                    'id' => $user['User']['id'],
                    'email' => $user['User']['email'],
                    'personal_name' => $user['User']['personal_name'],
                    'personal_lastname' => $user['User']['personal_lastname'],
                    'avatar' => $avatar,
                    'username' => $user['User']['username'],
                );
                # save last login
                $this->loadModel('ServiceUser');
                $this->ServiceUser->id = $this->PassportApi->find('serviceusers', array(
                    'conditions' => array(
                        'service_id' => $user['Service'][0]['id'],
                        'user_id' => $user['User']['id']
                    ),
                    'contain' => array()
                ));
                $token = $this->createtoken($session_id, $user['Service'][0]['salt'], array(
                    'expires' => strtotime('+2 minutes'),
                    'user' => $user_data_to_pass
                ));
                $this->Auth->login($user['User']);
                $callback_url = null;
                if (isset($this->request->query['callback'])) {
                    $callback_url = '&return_url=' . urlencode($this->request->query['callback']);
                }
                $this->redirect($user['Service'][0]['callback_url'] . '/?token=' . urlencode($token) . $callback_url);
            } else { # if not we will attempt to create new user based on his facebook data or we will merge his existing account
                if ($user && $user['User']['email']) { # merge attempt
                    $this->PassportApi->field('users', $user['User']['id'], array('facebook_id', $user_data['id']));
                    $user = $this->PassportApi->find('users', array(
                        'conditions' => array(
                            'User.id' => $user['User']['id'],
                        ),
                        'contain' => array(
                            'Service' => array(
                                'fields' => array('Service.id', 'Service.callback_url', 'Service.salt'),
                                'conditions' => array('Service.checksum' => $service),
                            ),
                            'UserExpand',
                        ),
                    ));
                    if (!$user['Service']) { # the user does not have profile on given service
                        $this->loadModel('ServiceUser');
                        $service_to_add = $this->PassportApi->find('users', array(
                            'recursive' => -2,
                            'conditions' => array('checksum' => $service)
                        ));
//                        $this->_log(array('msg' => 'LC_PASZPORT_SERVICE_ADDED', 'ip' => $this->request->clientIp(), 'user_agent' => env('HTTP_USER_AGENT')));
                        $user['Service'][0] = $service_to_add['Service'];
                    }
                    if ($user['User']['photo']) {
                        $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
                    } else {
                        $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
                    }
                    $user_data_to_pass = array(
                        'id' => $user['User']['id'],
                        'email' => $user['User']['email'],
                        'personal_name' => $user['User']['personal_name'],
                        'personal_lastname' => $user['User']['personal_lastname'],
                        'avatar' => $avatar,
                        'username' => $user['User']['username'],
                    );
                    # save last login
                    $token = $this->createtoken($session_id, $user['Service'][0]['salt'], array(
                        'expires' => strtotime('+2 minutes'),
                        'user' => $user_data_to_pass
                    ));
                    $this->Auth->login($user['User']);
                    $callback_url = null;
                    if (isset($this->request->query['callback'])) {
                        $callback_url = '&return_url=' . urlencode($this->request->query['callback']);
                    }
                    $this->redirect($user['Service'][0]['callback_url'] . '/?token=' . urlencode($token) . $callback_url);
                } else { # new user
                    $this->User->create();
//                    $this->User->Behaviors->load('Upload.Upload', array('photo' => array('path' => '{ROOT}webroot{DS}uploads{DS}{model}{DS}{field}{DS}')));
//                    $this->_log(array('msg' => 'LC_PASZPORT_LOG_REGISTER_FB', 'ip' => $this->request->clientIp(), 'user_agent' => env('HTTP_USER_AGENT')));
                    $to_save = array(
                        'personal_name' => $user_data['first_name'],
                        'personal_lastname' => $user_data['last_name'],
                        'email' => $user_data['email'],
                        'password' => $this->Auth->password(md5($user_data['id'] . $user_data['email'])),
                        'facebook_id' => (int)$user_data['id'],
                        'personal_bday' => date('Y-m-d', strtotime($user_data['birthday'])),
                        'personal_gender' => $this->__fbGender($user_data['gender']),
                        'language_id' => $this->__fbLanguage($user_data['locale']),
                        'photo' => preg_replace('/https/', 'http', $user_data['picture']['data']['url']),
                        'source' => 'facebook',
                        'group_id' => 1, # personal group
                        'username' => $user_data['first_name'] . '' . $user_data['last_name'] . rand(0, 999),
                    );
                    if ($user = $this->PassportApi->Users->add($to_save)) {
                        $user = $user['user'];
                        $to_save['id'] = $user['User']['id'];
                        $user = $this->PassportApi->find('users', array(
                            'conditions' => array(
                                'User.id' => $to_save['id'],
                            ),
                            'contain' => array(
                                'Service' => array(
                                    'fields' => array('Service.id', 'Service.callback_url', 'Service.salt'),
                                    'conditions' => array('Service.checksum' => $service),
                                ),
                                'UserExpand',
                            ),
                        ));
                        if (!$user['Service']) { # the user does not have profile on given service
                            $this->loadModel('ServiceUser');
                            $service_to_add = $this->PassportApi->find('serviceusers', 'find', array(
                                'recursive' => -2,
                                'conditions' => array('checksum' => $service)
                            ));
                            $this->PassportApi->add('serviceusers', array(
                                'user_id' => $user['User']['id'],
                                'service_id' => $service_to_add['Service']['id'],
                            ));
                            $user['Service'][0] = $service_to_add['Service'];
                        }
                        if ($user['User']['photo']) {
                            $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
                        } else {
                            $avatar = $this->PassportApi->User()->avatarinline($user['User']['id']);
                        }
                        $user_data_to_pass = array(
                            'id' => $user['User']['id'],
                            'email' => $user['User']['email'],
                            'personal_name' => $user['User']['personal_name'],
                            'personal_lastname' => $user['User']['personal_lastname'],
                            'avatar' => $avatar,
                            'username' => $user['User']['username'],
                        );
                        # save last login
//                        $this->loadModel('ServiceUser');
//                        $this->ServiceUser->id = $this->ServiceUser->find('first', array('conditions' => array('service_id' => $user['Service'][0]['id'], 'user_id' => $user['User']['id']), 'contain' => array()));
//                        $this->ServiceUser->saveField('last_login', date('Y-m-d H:i:s'));
                        $token = $this->createtoken($session_id, $user['Service'][0]['salt'], array(
                            'expires' => strtotime('+2 minutes'),
                            'user' => $user_data_to_pass
                        ));
                        $this->Auth->login($user['User']);
                        $callback_url = null;
                        if (isset($this->request->query['callback'])) {
                            $callback_url = '&return_url=' . urlencode($this->request->query['callback']);
                        }
                        $this->redirect($user['Service'][0]['callback_url'] . '/?token=' . urlencode($token) . $callback_url);
                    } else {
                        $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FACEBOOK_REGISTER_FAILED', true), null, array('class' => 'alert-error'));
                        $this->redirect(array('action' => 'login'));
                    }

                }
            }
        }
    }

    public function twitter()
    {
        $token = new OAuthToken($this->Session->read('twitter_request_token.key'), $this->Session->read('twitter_request_token.secret'));
        $requestToken = $token;
        $accessToken = $this->OAuthConsumer->getAccessToken('Twitter', 'https://api.twitter.com/oauth/access_token', $requestToken);
        if ($accessToken) {
            $user_data = $this->OAuthConsumer->get('Twitter', $accessToken->key, $accessToken->secret, 'https://api.twitter.com/1.1/account/verify_credentials.json');
            $user = $this->User->twitter(json_decode($user_data->body, true));
            $this->Auth->login($user);
            if ($this->Session->read('API.gate')) {
                $service = $this->Session->read('API.service');
                $session = $this->Session->read('API.session');
                $this->externalgate($service, $session);
            }
            $this->redirect(array('action' => 'index'));
        }
    }


    //@TODO

    public function twitterattach()
    {
        if (isset($this->request->query['oauth_verifier'])) {
            $token = new OAuthToken($this->Session->read('twitter_request_token.key'), $this->Session->read('twitter_request_token.secret'));
            $requestToken = $token;
            $accessToken = $this->OAuthConsumer->getAccessToken('Twitter', 'https://api.twitter.com/oauth/access_token', $requestToken);
            if ($accessToken) {
                $user_data = $this->OAuthConsumer->get('Twitter', $accessToken->key, $accessToken->secret, 'https://api.twitter.com/1.1/account/verify_credentials.json');
                $user_data = json_decode($user_data->body, true);
                $this->User->id = $this->Auth->user('id');
                $to_save = array(
                    'User' => array(
                        'twitter_id' => $user_data['id'],
                    ),
                );
                $user_photo = $this->User->find('first', array(
                    'conditions' => array('User.id' => $this->Auth->user('id')),
                    'recursive' => -2,
                    'fields' => array('User.photo')
                ));
                if (!$user_photo['User']['photo']) {
                    $this->User->Behaviors->load('Upload.Upload', array('photo' => array('path' => '{ROOT}webroot{DS}uploads{DS}{model}{DS}{field}{DS}')));
                    $to_save['User']['photo'] = preg_replace('/_normal/', 'http', $user_data['profile_image_url']);
                }
                if ($this->User->save($to_save)) {
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_TWITTER_ACCOUNT_MERGED', true), 'alert', array('class' => 'alert-success'));
                    $this->_log(array(
                        'msg' => 'LC_PASZPORT_TWITTER_ACCOUNT_MERGED',
                        'ip' => $this->request->clientIp(),
                        'user_agent' => env('HTTP_USER_AGENT')
                    ));
                } else {
                    $this->Session->setFlash(implode('. ', array_pop($this->User->validationErrors)), 'alert', array('class' => 'alert-error'));
                }
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->twitterlogin(array('action' => 'twitterattach'));
        }
    }

    //@TODO : redo that all

    public function twitterlogin($callback = null)
    {
        if (is_null($callback)) {
            $callback = Router::url(array('plugin' => false, 'controller' => 'users', 'action' => 'twitter'), true);
        } else {
            $callback = Router::url($callback, true);
        }
        $requestToken = $this->OAuthConsumer->getRequestToken('Twitter', 'https://api.twitter.com/oauth/request_token', $callback);
        if ($requestToken) {
            $this->Session->write('twitter_request_token', (array)$requestToken);
            $this->redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
        }
    }

    //@TODO : redo that all

    public function twitterdeattach()
    {

        $this->PassportApi->deletefield('users', $this->Auth->user('id'), 'twitter_id');
        $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_TWITTER_DEATTACHED', true), null, array('class' => 'alert-success'));
        $this->redirect(array('action' => 'index'));
    }

    //@TODO

    public function switchstreams()
    {

        if (($user_id = $this->Auth->user('id')) && isset($this->request->query['stream'])) {
            $data = $this->PassportApi->info();
            if ($data && ($streams = $data['streams'])) {
                if (array_key_exists($this->request->query['stream'], $streams)) {
                    $this->Session->write('Stream.id', $this->request->query['stream']);
                    $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_FLASH_MESSAGE_SWITCH_STREAM', true) . ': ' . $streams[$this->request->query['stream']], 'flash', array('class' => 'alert-success'));
                }
            }
        }

        $this->redirect($this->referer(null, true));
    }

    /**
     * Verifies passwords before changing it
     *
     * @return bool
     */
    protected function verifyPasswords()
    {
        $user = $this->PassportApi->find('users', array(
            'recursive' => -2,
            'conditions' => array('User.id' => $this->Auth->user('id')),
            'fields' => 'User.password'
        ));
        if ($this->Auth->password($this->data['User']['pass']) != $user['user']['User']['password']) {
            return false;
        }
        if ($this->data['User']['newpass'] != $this->data['User']['confirmnewpass']) {
            return false;
        }

        return true;
    }
}
