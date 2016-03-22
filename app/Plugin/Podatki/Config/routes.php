<?
Router::connect('/podatki', array('plugin' => 'Podatki', 'controller' => 'Podatki', 'action' => 'view'));
Router::connect('/podatki/stat', array('plugin' => 'Podatki', 'controller' => 'Podatki', 'action' => 'stat'));

