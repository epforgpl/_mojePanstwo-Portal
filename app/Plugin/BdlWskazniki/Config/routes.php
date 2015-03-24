<?

	Router::connect('/bdlwskazniki', array('plugin' => 'BdlWskazniki', 'controller' => 'BdlWskazniki', 'action' => 'view'));
	Router::connect('/bdlwskazniki/:action', array('plugin' => 'BdlWskazniki', 'controller' => 'BdlWskazniki'));
