<?php

Router::connect('/moja_gmina', array('plugin' => 'MojaGmina', 'controller' => 'MojaGmina', 'action' => 'view',));

Router::connect(
    '/moja_gmina/search',
    array(
        'plugin' => 'MojaGmina',
        'controller' => 'MojaGmina',
        'action' => 'search',
    )
);

Router::connect(
    '/moja_gmina/geo/:action',
    array(
        'plugin' => 'MojaGmina',
        'controller' => 'Geo',
    )
);

Router::connect('/moja_gmina/:id', array('plugin' => 'MojaGmina', 'controller' => 'MojaGmina', 'action' => 'action',));
