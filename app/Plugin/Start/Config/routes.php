<?php

Router::connect('/start', array('plugin' => 'Start', 'controller' => 'Start', 'action' => 'view'));

Router::connect('/moje-kolekcje', array('plugin' => 'Start', 'controller' => 'Start', 'action' => 'kolekcje',));
Router::connect('/moje-kolekcje/dodaj', array('plugin' => 'Start', 'controller' => 'Start', 'action' => 'dodaj_kolekcje'));
Router::connect('/moje-kolekcje/:id', array('plugin' => 'Start', 'controller' => 'Start', 'action' => 'kolekcja'), array('id' => '[0-9]{1,}', 'pass' => array('id')));

Router::connect('/moje-pisma', array('plugin' => 'Start', 'controller' => 'Letters', 'action' => 'index'));
Router::connect('/moje-pisma/:action', array('plugin' => 'Start', 'controller' => 'Letters'));
