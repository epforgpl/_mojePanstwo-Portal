<?php

Router::connect('/kody_pocztowe/adres/:adres_id', array(
    'plugin' => 'kody_pocztowe',
    'controller' => 'kody_pocztowe',
    'action' => 'adres'
));


Router::connect('/kody_pocztowe/znajdz-adres', array(
    'plugin' => 'kody_pocztowe',
    'controller' => 'kody_pocztowe',
    'action' => 'address'
));
Router::connect('/kody_pocztowe/znajdz-kod/*', array(
    'plugin' => 'kody_pocztowe',
    'controller' => 'kody_pocztowe',
    'action' => 'code'
));
Router::connect('/kody_pocztowe/:action/*', array('plugin' => 'kody_pocztowe', 'controller' => 'kody_pocztowe'));
Router::connect('/kody_pocztowe/*', array('plugin' => 'kody_pocztowe', 'controller' => 'kody_pocztowe'));
