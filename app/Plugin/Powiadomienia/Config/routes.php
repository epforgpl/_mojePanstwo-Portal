<?

Router::connect('/moje-dane', array('plugin' => 'Powiadomienia', 'controller' => 'Powiadomienia', 'action' => 'view'));
Router::connect('/moje-dane/:action', array('plugin' => 'Powiadomienia', 'controller' => 'Powiadomienia'));

Router::connect('/powiadomienia', array('plugin' => 'Powiadomienia', 'controller' => 'Powiadomienia', 'action' => 'view'));
Router::connect('/powiadomienia/:action', array('plugin' => 'Powiadomienia', 'controller' => 'Powiadomienia'));
