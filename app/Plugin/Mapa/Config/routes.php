<?php
Router::connect('/mapa', array('plugin' => 'Mapa', 'controller' => 'mapa', 'action' => 'view'));
Router::connect('/mapa/grid', array('plugin' => 'Mapa', 'controller' => 'mapa', 'action' => 'grid'));
Router::connect('/mapa/obwody', array('plugin' => 'Mapa', 'controller' => 'mapa', 'action' => 'obwody'));
Router::connect('/mapa/geodecode', array('plugin' => 'Mapa', 'controller' => 'mapa', 'action' => 'geodecode'));

Router::connect('/mapa/miejsce/:id', array(
	'plugin' => 'Mapa', 
	'controller' => 'Places', 
	'action' => 'view'
), array(
	'id' => '([0-9]+)',
	'pass' => array('id'),
));

Router::connect('/mapa/:code', array(
	'plugin' => 'Mapa', 
	'controller' => 'Codes', 
	'action' => 'view'
), array(
	'code' => '([0-9]{2}\-[0-9]{3})',
	'pass' => array('code'),
));