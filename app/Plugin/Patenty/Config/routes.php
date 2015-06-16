<?

Router::connect('/patenty', array('plugin' => 'Patenty', 'controller' => 'Patenty', 'action' => 'view'));
Router::connect('/patenty/:action', array('plugin' => 'Patenty', 'controller' => 'Patenty'));
