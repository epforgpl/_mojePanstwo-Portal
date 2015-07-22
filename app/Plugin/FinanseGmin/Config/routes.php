<?

Router::connect('/finanse_gmin', array('plugin' => 'FinanseGmin', 'controller' => 'FinanseGmin', 'action' => 'index'));
Router::connect('/finanse_gmin/:action', array('plugin' => 'FinanseGmin', 'controller' => 'FinanseGmin'));
