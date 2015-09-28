<?php
/* START ROUTES */
Router::connect('/start', array('plugin' => 'Start', 'controller' => 'Start', 'action' => 'view'));


/* MOJE KOLEKCJE ROUTES */
Router::connect('/moje-kolekcje', array('plugin' => 'Start', 'controller' => 'Collections', 'action' => 'index'));
Router::connect('/moje-kolekcje/nowe', array('plugin' => 'Start', 'controller' => 'Collections', 'action' => 'add'));
Router::connect('/moje-kolekcje/:id', array('plugin' => 'Start', 'controller' => 'Collections', 'action' => 'view'), array(
    'id' => '[0-9]{1,}', 'pass' => array('id'))
);

Router::connect('/moje-kolekcje/:id/edytuj', array('plugin' => 'Start', 'controller' => 'Collections', 'action' => 'edit'), array(
        'id' => '[0-9]{1,}', 'pass' => array('id'))
);



/* MOJE PISMA ROUTES*/
$pisma_prefixes = array('/moje-pisma');
foreach ($pisma_prefixes as $pisma_prefix) {
    Router::connect("$pisma_prefix", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'my',
        '[method]' => 'GET'
    ));
    Router::connect("$pisma_prefix/nowe", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'home',
        '[method]' => 'GET'
    ));
    Router::connect("$pisma_prefix/moje", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'my',
        '[method]' => 'GET'
    ));
    Router::connect("$pisma_prefix/moje", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'post',
        '[method]' => 'POST'
    ));
    Router::connect("$pisma_prefix", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'create',
        '[method]' => 'POST'
    ));


    // GET

    Router::connect("$pisma_prefix/:id,:slug", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'view',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id', 'slug')));

    Router::connect("$pisma_prefix/:id", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'view',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));

    Router::connect("$pisma_prefix/:id,", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'view',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));


    // POST

    Router::connect("$pisma_prefix/:id,:slug", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'post',
        '[method]' => 'POST'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id', 'slug')));

    Router::connect("$pisma_prefix/:id", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'post',
        '[method]' => 'POST'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));

    Router::connect("$pisma_prefix/:id,", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'post',
        '[method]' => 'POST'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));


    // PUT

    Router::connect("$pisma_prefix/:id,:slug", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'put',
        '[method]' => 'PUT'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id', 'slug')));

    Router::connect("$pisma_prefix/:id", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'put',
        '[method]' => 'PUT'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));

    Router::connect("$pisma_prefix/:id,", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'put',
        '[method]' => 'PUT'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));


    // EDIT

    Router::connect("$pisma_prefix/:id,:slug/edit", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'edit',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id', 'slug')));

    Router::connect("$pisma_prefix/:id/edit", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'edit',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));

    Router::connect("$pisma_prefix/:id,/edit", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'edit',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));


    // HTML

    Router::connect("$pisma_prefix/:id,:slug/html", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'html',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id', 'slug')));

    Router::connect("$pisma_prefix/:id/html", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'html',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));

    Router::connect("$pisma_prefix/:id,/html", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'html',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));


    // SHARE

    Router::connect("$pisma_prefix/:id,:slug/share", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'share',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id', 'slug')));

    Router::connect("$pisma_prefix/:id/share", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'share',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));

    Router::connect("$pisma_prefix/:id,/share", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        'action' => 'share',
        '[method]' => 'GET'
    ), array('id' => '[A-Za-z0-9]{5}', 'pass' => array('id')));

    Router::connect("$pisma_prefix/:action", array(
        'plugin' => 'Start',
        'controller' => 'Letters',
        '[method]' => 'GET'
    ));
}


/* MOJE POWIADOMIENIA ROUTES */
Router::connect('/moje-powiadomienia', array('plugin' => 'Start', 'controller' => 'Alerts', 'action' => 'index'));
Router::connect('/moje-powiadomienia/obserwuje', array('plugin' => 'Start', 'controller' => 'Alerts', 'action' => 'subscriptions',));
Router::connect('/moje-powiadomienia/:action', array('plugin' => 'Start', 'controller' => 'Alerts'));