<?php

Router::connect('/api/technical_info', array(
    'plugin' => 'api',
    'controller' => 'api',
    'action' => 'technical_info'
));

// API z dedykowanym opisem (zawartym w Api/View/Elements
Router::connect('/api/:slug/*', array(
    'plugin' => 'api',
    'controller' => 'api',
    'action' => 'view'
), array(
        'slug' => 'bdl',
        'pass' => array('slug')
));

Router::connect('/api/*', array('plugin' => 'api', 'controller' => 'api', 'action' => 'index'));
