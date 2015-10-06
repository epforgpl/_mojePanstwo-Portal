<?php
Router::connect('/mapa', array('plugin' => 'Mapa', 'controller' => 'mapa', 'action' => 'view'));
Router::connect('/mapa/geodecode', array('plugin' => 'Mapa', 'controller' => 'mapa', 'action' => 'geodecode'));
Router::connect('/mapa/miejsce/:id', array(
	'plugin' => 'Mapa', 
	'controller' => 'Places', 
	'action' => 'view'
), array(
	'id' => '([0-9]+)',
	'pass' => array('id'),
));
