<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends PaszportAppController
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Pages';

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();

    /**
     * Displays a view
     *
     * @param mixed What page to display
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('regulations', 'privacy');
    }

    public function logs()
    {
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_LOGS', true));
    }

    public function home()
    {
        if ($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }
    }

    public function regulations()
    {
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_REGULATIONS', true));
    }

    public function privacy()
    {
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_PRIVACY_POLICY', true));
    }

}
