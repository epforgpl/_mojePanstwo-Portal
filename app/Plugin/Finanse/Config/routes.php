<?
	
Router::connect('/finanse', array('plugin' => 'Finanse', 'controller' => 'Finanse', 'action' => 'view'));
Router::connect('/finanse/:action', array('plugin' => 'Finanse', 'controller' => 'Finanse'));