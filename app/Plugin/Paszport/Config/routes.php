<?php

Router::connect('/login', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'login'));
Router::connect('/paszport', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'profile'));
Router::connect('/logout', array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'logout'));
// Router::connect('/register', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'register'));
Router::connect('/forgot', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'forgot'));

Router::connect('/paszport/klucze', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'keys'));
Router::connect('/paszport/logi', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'logs'));

Router::connect('/paszport/user/setUserName', array('plugin' => 'paszport', 'controller' => 'AjaxRequest', 'action' => 'setUserName'));
Router::connect('/paszport/user/setEmail', array('plugin' => 'paszport', 'controller' => 'AjaxRequest', 'action' => 'setEmail'));
Router::connect('/paszport/user/setPassword', array('plugin' => 'paszport', 'controller' => 'AjaxRequest', 'action' => 'setPassword'));
Router::connect('/paszport/user/setIsNgo', array('plugin' => 'paszport', 'controller' => 'AjaxRequest', 'action' => 'setIsNgo'));
Router::connect('/paszport/user/createNewPassword', array('plugin' => 'paszport', 'controller' => 'AjaxRequest', 'action' => 'createNewPassword'));
Router::connect('/paszport/user/delete', array('plugin' => 'paszport', 'controller' => 'AjaxRequest', 'action' => 'delete'));

Router::connect('/fblogin', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'facebookLogin'));
Router::connect('/paszport/users/fblogin', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'facebookLogin'));
Router::connect('/authorize', array('plugin' => 'paszport', 'controller' => 'passports', 'action' => 'authorize'));

Router::connect('/cross-domain-login', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'cross_domain_login'));
Router::connect('/cross-domain-logout', array('plugin' => 'paszport', 'controller' => 'paszport', 'action' => 'cross_domain_logout'));

Router::redirect('/paszport/users/failed', array(
    'plugin' => 'paszport',
    'controller' => 'users',
    'action' => 'login'
));

Router::connect('/paszport/tutoriale', array('plugin' => 'paszport', 'controller' => 'tutorials', 'action' => 'index', '[method]' => 'GET'));
Router::connect('/paszport/tutoriale/:id', array('plugin' => 'paszport', 'controller' => 'tutorials', 'action' => 'edit', '[method]' => 'POST'), array('id' => '[0-9]+', 'pass' => array('id')));

Router::redirect('/pages/fblogin', array('plugin' => 'paszport', 'controller' => 'users', 'action' => 'fblogin'));

Router::connect('/paszport/users/email', array('plugin' => 'paszport', 'controller' => 'AjaxRequest', 'action' => 'getUsersByEmail', '[method]' => 'POST'));

