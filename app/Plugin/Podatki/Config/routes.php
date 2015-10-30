<?
Router::connect('/podatki', array('plugin' => 'Podatki', 'controller' => 'Podatki', 'action' => 'view'));
Router::connect('/podatki/suma', array('plugin' => 'Podatki', 'controller' => 'Podatki', 'action' => 'results'));

