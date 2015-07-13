<?

Router::connect('/sadometr', array('plugin' => 'Sadometr', 'controller' => 'Sadometr', 'action' => 'view'));
Router::connect('/sadometr/:action', array('plugin' => 'Sadometr', 'controller' => 'Sadometr'));
