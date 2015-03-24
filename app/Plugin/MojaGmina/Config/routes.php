<?php

Router::connect('/moja_gmina/:action', array('plugin' => 'MojaGmina', 'controller' => 'MojaGmina'));

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