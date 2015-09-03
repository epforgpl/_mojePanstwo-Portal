<?

Router::connect('/finanse/samorzad', array('plugin' => 'FinanseGmin', 'controller' => 'FinanseGmin', 'action' => 'index'));
Router::connect('/finanse/samorzad/:action', array('plugin' => 'FinanseGmin', 'controller' => 'FinanseGmin'));

Router::connect('/finanse', array('plugin' => 'Finanse', 'controller' => 'Finanse', 'action' => 'view'));
Router::connect('/finanse/:action', array('plugin' => 'Finanse', 'controller' => 'Finanse'));
