<?php

Router::connect('/api', array('plugin' => 'api', 'controller' => 'api', 'action' => 'index'));
Router::connect('/api/technical_info', array(
    'plugin' => 'api',
    'controller' => 'api',
    'action' => 'technical_info'
));
Router::connect('/api/:slug/*', array(
    'plugin' => 'api',
    'controller' => 'api',
    'action' => 'view'
), array('pass' => array('slug')));