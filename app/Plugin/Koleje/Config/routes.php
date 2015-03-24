<?

	Router::connect('/koleje', array('plugin' => 'Koleje', 'controller' => 'Koleje', 'action' => 'view'));
	Router::connect('/koleje/:action', array('plugin' => 'Koleje', 'controller' => 'Koleje'));
