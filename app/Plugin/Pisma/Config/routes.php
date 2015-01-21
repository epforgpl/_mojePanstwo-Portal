<?php

$pisma_prefix = '/pisma';

Router::connect("$pisma_prefix", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'home',
    '[method]' => 'GET'
));
Router::connect("$pisma_prefix/nowe", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'home',
    '[method]' => 'GET'
));
Router::connect("$pisma_prefix/moje", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'my',
    '[method]' => 'GET'
));
Router::connect("$pisma_prefix", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'create',
    '[method]' => 'POST'
));

Router::connect("$pisma_prefix/szablon/:szablon_id/adresat/:adresat_id", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'editor',
    '[method]' => 'GET'
), array(
    'szablon_id' => '[0-9]+',
    'adresat_id' => '[0-9]+',
));
Router::connect("$pisma_prefix/szablon/:szablon_id", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'editor',
    '[method]' => 'GET'
), array(
    'szablon_id' => '[0-9]+',
));








Router::connect("$pisma_prefix/:id,:slug", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'view',
    '[method]' => 'GET'
), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id', 'slug')));
Router::connect("$pisma_prefix/:id,:slug/edit", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'edit',
    '[method]' => 'GET'
), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id', 'slug')));

Router::connect("$pisma_prefix/:id", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'view',
    '[method]' => 'GET'
), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));
Router::connect("$pisma_prefix/:id/edit", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'edit',
    '[method]' => 'GET'
), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));








Router::connect("$pisma_prefix/:id/delete", array(
    'plugin' => 'Pisma',
    'controller' => 'Pisma',
    'action' => 'delete'
), array('id' => '[0-9]+', 'pass' => array('id')));

Router::connect("$pisma_prefix/szablony/:id", array(
    'plugin' => 'Pisma',
    'controller' => 'Szablony',
    'action' => 'view'
), array('id' => '[0-9]+', 'pass' => array('id')));
