<?

Router::connect('/moje-dane', array('plugin' => 'MojeDane', 'controller' => 'Powiadomienia', 'action' => 'view'));
Router::connect('/moje-dane/:action', array('plugin' => 'MojeDane', 'controller' => 'Powiadomienia'));

Router::connect('/powiadomienia', array('plugin' => 'MojeDane', 'controller' => 'Powiadomienia', 'action' => 'view'));
Router::connect('/powiadomienia/:action', array('plugin' => 'MojeDane', 'controller' => 'Powiadomienia'));
