<?

Router::connect('/krs', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'view'));
Router::connect('/krs/:id', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'action',));
Router::connect('/krs/pkd/:id', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'pkd',));
