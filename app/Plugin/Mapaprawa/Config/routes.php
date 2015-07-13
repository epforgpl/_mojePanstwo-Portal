<?php
Router::connect('/mapaprawa', array('plugin' => 'Mapaprawa', 'controller' => 'mapaprawa', 'action' => 'index'));
Router::connect('/mapaprawa/:projekt_id', array(
    'plugin' => 'Mapaprawa',
    'controller' => 'mapaprawa',
    'action' => 'view'
), array('projekt_id' => '[0-9]+'));
Router::connect('/mapaprawa/:projekt_id/:action', array('plugin' => 'Mapaprawa', 'controller' => 'mapaprawa'));
Router::connect('/mapaprawa/:action', array('plugin' => 'Mapaprawa', 'controller' => 'mapaprawa'));