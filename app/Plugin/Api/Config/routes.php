<?

Router::connect('/api/:action', array('plugin' => 'Api', 'controller' => 'Api', 'action' => 'index'));