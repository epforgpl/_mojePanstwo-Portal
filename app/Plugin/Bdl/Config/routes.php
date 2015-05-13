<?

Router::connect('/bdl', array('plugin' => 'Bdl', 'controller' => 'Bdl', 'action' => 'view'));
Router::connect('/bdl/:action', array('plugin' => 'Bdl', 'controller' => 'Bdl'));
