<?

	Router::connect('/krs', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'view'));
	Router::connect('/krs/:action', array('plugin' => 'Krs', 'controller' => 'Krs'));
