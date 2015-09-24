<?php

Router::connect('/start', array('plugin' => 'Start', 'controller' => 'Start', 'action' => 'view'));

Router::connect('/moje-kolekcje', array('plugin' => 'Start', 'controller' => 'Collections', 'action' => 'index'));
Router::connect('/moje-kolekcje/nowe', array('plugin' => 'Start', 'controller' => 'Collections', 'action' => 'add'));
Router::connect('/moje-kolekcje/:id', array('plugin' => 'Start', 'controller' => 'Collections', 'action' => 'view'), array(
    'id' => '[0-9]{1,}', 'pass' => array('id'))
);

Router::connect('/moje-pisma', array('plugin' => 'Start', 'controller' => 'Letters', 'action' => 'index'));
Router::connect('/moje-pisma/:action', array('plugin' => 'Start', 'controller' => 'Letters'));

Router::connect('/moje-powiadomienia', array('plugin' => 'Start', 'controller' => 'Alerts', 'action' => 'index'));
Router::connect('/moje-powiadomienia/obserwuje', array('plugin' => 'Start', 'controller' => 'Alerts', 'action' => 'subscriptions',));
Router::connect('/moje-powiadomienia/:action', array('plugin' => 'Start', 'controller' => 'Alerts'));
