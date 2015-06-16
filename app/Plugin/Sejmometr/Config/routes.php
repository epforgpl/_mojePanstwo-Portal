<?

Router::connect('/sejmometr', array('plugin' => 'Sejmometr', 'controller' => 'Sejmometr', 'action' => 'view'));
Router::connect('/sejmometr/okregi', array('plugin' => 'Sejmometr', 'controller' => 'Sejmometr', 'action' => 'okregi',));
Router::connect('/sejmometr/:id', array('plugin' => 'Sejmometr', 'controller' => 'Sejmometr', 'action' => 'action',));
