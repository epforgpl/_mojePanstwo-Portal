<?php
Router::connect('/ngo', array('plugin' => 'ngo', 'controller' => 'ngo', 'action' => 'addDeclaration', '[method]' => 'POST'));
Router::connect('/ngo', array('plugin' => 'ngo', 'controller' => 'ngo', 'action' => 'view'));
Router::connect('/ngo/:id', array('plugin' => 'ngo', 'controller' => 'ngo', 'action' => 'page',), array(
	'id' => 'uchodzcy'
));
Router::connect('/ngo/:action', array('plugin' => 'ngo', 'controller' => 'ngo',));
