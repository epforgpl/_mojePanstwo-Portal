<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::import('Vendor', 'Paszport.Encrypt');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class PaszportAppController extends AppController
{
    public $components = array(
//        'Session' => array('className' => 'Passport.MySession'),
        'Session',
        'DebugKit.Toolbar',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
                'plugin' => 'paszport'
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email', 'password' => 'password'),
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'sha256'
                    ),
                    'userModel' => 'Paszport.User',
                )
            )
        ),
        'RequestHandler',
        'Facebook.Connect',
        'OAuth.OAuth'
    );
    public $helpers = array(
//        'Session' => array('className' => 'Passport.MySession'),
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator',
        'BoostCake.BoostCakePaginator',
        'Time',
        'Paszport.Image2',
        'Less.Less',
        'Facebook.Facebook',

    );

    public $uses = array('Paszport.User');

    public $PassportApi;

    public function beforeFilter()
    {
	    return $this->redirect('/');
        parent::beforeFilter();

        $this->Auth->deny(); // default is to deny all

        $this->Auth->authError = __d('paszport', 'LC_PASZPORT_UNAUTHORIZED', true);
        if ($this->Auth->loggedIn()) {
            $avatar_for_layout = $this->Auth->user('photo_small');
        } else {
            $avatar_for_layout = false;
        }
        $this->set(compact('avatar_for_layout'));

        /*
        if (!$this->Auth->loggedIn()) {
            $this->layout = 'Paszport.notlogged';
        } else {
            $this->layout = 'Paszport.default';
        }
        */

        $this->OAuth->allow();
        // $this->PassportApi = $this->API->Paszport();
        $this->Session->write('Config.language', Configure::read('Config.language'));
    }

    /**
     * Log sink
     *
     * @param array $log array('msg','ip','user_id')
     *
     * @return bool
     */
    protected function _log($log = array())
    {
        return true;
    }


}
