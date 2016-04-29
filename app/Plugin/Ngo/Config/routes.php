<?php
Router::connect('/ngo', array('plugin' => 'Ngo', 'controller' => 'Ngo', 'action' => 'addDeclaration', '[method]' => 'POST'));
Router::connect('/ngo', array('plugin' => 'Ngo', 'controller' => 'Ngo', 'action' => 'view'));
Router::connect('/ngo/:id', array('plugin' => 'Ngo', 'controller' => 'Ngo', 'action' => 'page',), array(
	'id' => 'uchodzcy'
));
Router::connect('/ngo/:action', array('plugin' => 'Ngo', 'controller' => 'Ngo',));

Router::connect('/ngo/zbiorki_publiczne/formularz', array('plugin' => 'Ngo', 'controller' => 'Ngo', 'action' => 'zbiorki_publiczne_formularz'));
Router::connect('/ngo/zbiorki_publiczne/:action', array('plugin' => 'Ngo', 'controller' => 'Ngo', 'action' => 'zbiorki_publiczne'));
Router::connect('/ngo/zbiorki_publiczne/*', array('plugin' => 'Ngo', 'controller' => 'Ngo', 'action' => 'zbiorki_publiczne'));

