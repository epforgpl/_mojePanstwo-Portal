<?php

Router::connect('/paszport', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'login'));
Router::connect('/paszport/klucze', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'keys'));
Router::connect('/paszport/logi', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'logs'));

Router::connect('/paszport/users/login', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'login'));
Router::connect('/paszport/users', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'login'));

Router::connect('/login', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'login'));
Router::redirect('/zaloguj', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'login'));
Router::redirect('/logowanie', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'login'));
Router::connect('/logout', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'logout'));
Router::connect('/register', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'register'));

Router::connect('/fblogin', array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'fblogin'));
Router::connect('/authorize', array('plugin' => 'paszport', 'controller' => 'passports', 'action' => 'authorize'));
Router::connect('/forgot', array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'forgot'));

Router::redirect('/paszport/users/failed', array(
    'plugin' => 'paszport',
    'controller' => 'users',
    'action' => 'login'
));
Router::redirect('/pages/fblogin', array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'fblogin'));
