<?

	Router::connect('/powiadomienia', array('plugin' => 'Powiadomienia', 'controller' => 'Powiadomienia', 'action' => 'view'));
	Router::connect('/powiadomienia/:action', array('plugin' => 'Powiadomienia', 'controller' => 'Powiadomienia'));
