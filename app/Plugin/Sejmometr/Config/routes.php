<?

Router::connect('/sejmometr', array('plugin' => 'Sejmometr', 'controller' => 'Sejmometr', 'action' => 'view'));
Router::connect('/sejmometr/:action', array('plugin' => 'Sejmometr', 'controller' => 'Sejmometr'));