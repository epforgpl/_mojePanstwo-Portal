<?

Router::connect('/krs', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'view'));
Router::connect('/krs/msig_wydania', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'msig_wydania',));
Router::connect('/krs/msig', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'msig',));
Router::connect('/krs/:id', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'action',));
Router::connect('/krs/pkd/:id', array('plugin' => 'Krs', 'controller' => 'Krs', 'action' => 'pkd',));
