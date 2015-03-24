<?php

App::uses('ApplicationsController', 'Controller');

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

    public function login()
    {
        $this->setMenuSelected();
    }

    public function register()
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

                foreach($user['errors'] as $key => $err_list) {
                    $this->User->validationErrors[$key] = array_map($__p, $err_list);
                }
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
    }

} 