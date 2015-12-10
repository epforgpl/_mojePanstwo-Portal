<?
Router::connect('/podatki', array('plugin' => 'Podatki', 'controller' => 'Podatki', 'action' => 'view'));
Router::connect('/podatki/metodologia', array('plugin' => 'Podatki', 'controller' => 'Podatki', 'action' => 'metodologia'));

