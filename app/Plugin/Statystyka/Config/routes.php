<?

	Router::connect('/statystyka', array('plugin' => 'Statystyka', 'controller' => 'Statystyka', 'action' => 'view'));
	Router::connect('/statystyka/:action', array('plugin' => 'Statystyka', 'controller' => 'Statystyka'));
