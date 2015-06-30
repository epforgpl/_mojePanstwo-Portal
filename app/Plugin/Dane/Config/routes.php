<?php

//Router::connect('/dane', array('plugin' => 'Dane', 'controller' => 'datasets', 'action' => 'katalog'));

/*
Router::connect('/dane', array('plugin' => 'Dane', 'controller' => 'datasets', 'action' => 'index'));
Router::connect('/dane/szukaj', array('plugin' => 'Dane', 'controller' => 'dataobjects', 'action' => 'index'));
Router::connect('/dane/suggest', array('plugin' => 'Dane', 'controller' => 'dataobjects', 'action' => 'suggest'));

Router::connect('/dane/dataobjects/:object_id/:action', array('plugin' => 'Dane', 'controller' => 'dataobjects'), array('object_id' => '[0-9]+', 'pass' => array('object_id')));


Router::redirect('/dane/ustawy', '/dane/prawo');


Router::connect('/dane/kanal/:alias', array(
    'plugin' => 'Dane',
    'controller' => 'datachannels',
    'action' => 'view'
));

Router::connect('/dane/:controller/:id', array('plugin' => 'Dane', 'action' => 'view'), array('id' => '[0-9]+'));
Router::connect('/dane/:controller/:id,', array('plugin' => 'Dane', 'action' => 'view'), array('id' => '[0-9]+'));
Router::connect('/dane/:controller/:id,:slug', array('plugin' => 'Dane', 'action' => 'view'), array('id' => '[0-9]+'));


// CUSTOM

Router::connect('/dane/bdl_wskazniki/:id/:dim_id', array(
    'plugin' => 'Dane',
    'controller' => 'bdl_wskazniki',
    'action' => 'view_dimension'
), array('id' => '[0-9]+', 'dim_id' => '[0-9]+'));
Router::connect('/dane/bdl_wskazniki/:id,:slug/:dim_id', array(
    'plugin' => 'Dane',
    'controller' => 'bdl_wskazniki',
    'action' => 'view_dimension'
), array('id' => '[0-9]+', 'dim_id' => '[0-9]+'));


Router::connect('/dane/bdl_wskazniki/:id/:dim_id/:level', array(
    'plugin' => 'Dane',
    'controller' => 'bdl_wskazniki',
    'action' => 'view_dimension'
), array('id' => '[0-9]+', 'dim_id' => '[0-9]+', 'level'));
Router::connect('/dane/bdl_wskazniki/:id,:slug/:dim_id/:level', array(
    'plugin' => 'Dane',
    'controller' => 'bdl_wskazniki',
    'action' => 'view_dimension'
), array('id' => '[0-9]+', 'dim_id' => '[0-9]+', 'level'));


Router::connect('/dane/sejm_interpelacje/:id/:t_id', array(
    'plugin' => 'Dane',
    'controller' => 'sejm_interpelacje',
    'action' => 'view'
), array('id' => '[0-9]+', 't_id' => '[0-9]+'));
Router::connect('/dane/sejm_interpelacje/:id,:slug/:t_id', array(
    'plugin' => 'Dane',
    'controller' => 'sejm_interpelacje',
    'action' => 'view'
), array('id' => '[0-9]+', 't_id' => '[0-9]+'));


Router::connect('/dane/:controller/:id/:action/*', array('plugin' => 'Dane'), array('id' => '[0-9]+'));
Router::connect('/dane/:controller/:id,:slug/:action/*', array('plugin' => 'Dane'), array('id' => '[0-9]+'));
*/

/*
Router::connect( '/dane/:controller/:slug/:id', array(
	'plugin'     => 'Dane',
	'controller' => 'dataobjects',
	'action'     => 'view'
), array( 'id' => '[0-9]+' ) );
*/

# ObjectUsersManagement
Router::connect('/dane/:dataset/:object_id/users/index', array('plugin' => 'Dane', 'controller' => 'ObjectUsersManagement', 'action' => 'index', '[method]' => 'GET'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/users/index', array('plugin' => 'Dane', 'controller' => 'ObjectUsersManagement', 'action' => 'add', '[method]' => 'POST'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/users/:user_id', array('plugin' => 'Dane', 'controller' => 'ObjectUsersManagement', 'action' => 'edit', '[method]' => 'PUT'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+', 'user_id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/users/:user_id', array('plugin' => 'Dane', 'controller' => 'ObjectUsersManagement', 'action' => 'delete', '[method]' => 'DELETE'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+', 'user_id' => '[0-9]+'));

# ObjectPagesManagement
Router::connect('/dane/:dataset/:object_id/page/logo', array('plugin' => 'Dane', 'controller' => 'ObjectPagesManagement', 'action' => 'setLogo', '[method]' => 'POST'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/page/logo', array('plugin' => 'Dane', 'controller' => 'ObjectPagesManagement', 'action' => 'deleteLogo', '[method]' => 'DELETE'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/page/cover', array('plugin' => 'Dane', 'controller' => 'ObjectPagesManagement', 'action' => 'setCover', '[method]' => 'POST'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/page/cover', array('plugin' => 'Dane', 'controller' => 'ObjectPagesManagement', 'action' => 'deleteCover', '[method]' => 'DELETE'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+'));

# Projects
Router::connect('/dane/:dataset/:object_id/dzialania', array('plugin' => 'Dane', 'controller' => 'Projects', 'action' => 'index', '[method]' => 'GET'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/dzialania', array('plugin' => 'Dane', 'controller' => 'Projects', 'action' => 'add', '[method]' => 'POST'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/dzialania/:id', array('plugin' => 'Dane', 'controller' => 'Projects', 'action' => 'view', '[method]' => 'GET'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+', 'id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/dzialania/:id', array('plugin' => 'Dane', 'controller' => 'Projects', 'action' => 'edit', '[method]' => 'PUT'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+', 'id' => '[0-9]+'));
Router::connect('/dane/:dataset/:object_id/dzialania/:id', array('plugin' => 'Dane', 'controller' => 'Projects', 'action' => 'delete', '[method]' => 'DELETE'), array('dataset' => '([a-zA-Z\_]+)', 'object_id' => '[0-9]+', 'id' => '[0-9]+'));

Router::connect('/dane', array('plugin' => 'Dane', 'controller' => 'Dane', 'action' => 'view'));

Router::connect('/dane/suggest', array(
    'plugin' => 'Dane',
    'controller' => 'Dataobjects',
    'action' => 'suggest',
    '[method]' => 'GET',
));

Router::connect('/dane/subscriptions/:id', array(
    'plugin' => 'Dane',
    'controller' => 'Subscriptions',
    'action' => 'view',
    '[method]' => 'GET',
), array(
    'pass' => array('id'),
));

Router::connect('/dane/subscriptions', array(
    'plugin' => 'Dane',
    'controller' => 'Subscriptions',
    'action' => 'add',
    '[method]' => 'POST',
));

Router::connect('/dane/subscriptions/:id/:action', array(
    'plugin' => 'Dane',
    'controller' => 'Subscriptions',
    '[method]' => 'POST',
), array(
    'action' => '(delete)',
    'pass' => array('id'),
));

Router::connect('/dane/zbiory', array(
    'plugin' => 'Dane',
    'controller' => 'Dane',
    'action' => 'zbiory'
));

Router::connect('/dane/:id', array(
    'plugin' => 'Dane',
    'controller' => 'Dane',
    'action' => 'action'
), array(
    'pass' => array('id'),
));


$map = array(
    '/:id',
    '/:id,',
    array(
        'pattern' => '/:id,:slug',
        'pass' => 'slug',
    ),
);

foreach ($map as $m) {

    if (is_string($m))
        $m = array(
            'pattern' => $m,
        );

    $pass = array('controller', 'id');

    if (isset($m['pass'])) {

        if (is_string($m['pass']))
            $pass[] = $m['pass'];
        elseif (is_array($m['pass']))
            $pass = array_merge($pass, $m['pass']);

    }

    Router::connect('/dane/:controller' . $m['pattern'], array(
        'plugin' => 'Dane',
        'action' => 'post',
        '[method]' => 'POST'
    ), array(
        'id' => '([0-9]+)',
        'pass' => $pass,
    ));
    
    Router::connect('/dane/:controller' . $m['pattern'], array(
        'plugin' => 'Dane',
        'action' => 'view',
    ), array(
        'id' => '([0-9]+)',
        'pass' => $pass,
    ));
    
    Router::connect('/dane/:controller' . $m['pattern'] . '/dzialania/nowe', array(
        'plugin' => 'Dane',
        'action' => 'dzialania_nowe',
    ), array(
        'id' => '([0-9]+)',
        'pass' => $pass,
    ));
	
    Router::connect('/dane/:controller' . $m['pattern'] . '/:action', array(
        'plugin' => 'Dane',
    ), array(
        'id' => '([0-9]+)',
        'action' => '([a-zA-Z\_]+)',
        'pass' => $pass,
    ));

    Router::connect('/dane/:controller' . $m['pattern'] . '/:action/:subid', array(
        'plugin' => 'Dane',
    ), array(
        'id' => '([0-9]+)',
        'action' => '([a-zA-Z\_]+)',
        'subid' => '([0-9]+)',
        'pass' => $pass,
    ));

    Router::connect('/dane/:controller' . $m['pattern'] . '/:action/:subid/:subaction', array(
        'plugin' => 'Dane',
    ), array(
        'id' => '([0-9]+)',
        'action' => '([a-zA-Z\_]+)',
        'subaction' => '([a-zA-Z\_]+)',
        'subid' => '([0-9]+)',
        'pass' => $pass,
    ));

    Router::connect('/dane/:controller' . $m['pattern'] . '/:action/:subid/:subaction/:subsubid', array(
        'plugin' => 'Dane',
    ), array(
        'id' => '([0-9]+)',
        'action' => '([a-zA-Z\_]+)',
        'subaction' => '([a-zA-Z\_]+)',
        'subid' => '([0-9]+)',
        'subsubid' => '([0-9]+)',
        'pass' => $pass,
    ));


    // LEGACY

    Router::connect('/dane/bdl_wskazniki' . $m['pattern'] . '/:subid', array(
        'plugin' => 'Dane',
        'controller' => 'BdlWskazniki',
        'action' => 'legacy_redirect'
    ), array(
        'id' => '([0-9]+)',
        'subid' => '([0-9]+)',
        'pass' => $pass,
    ));

}