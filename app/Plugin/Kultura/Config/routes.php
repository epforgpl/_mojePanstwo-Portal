<?

    Router::connect('/kultura', array('plugin' => 'Kultura', 'controller' => 'Kultura', 'action' => 'file'));
    Router::connect('/kultura/data/:id', array('plugin' => 'Kultura', 'controller' => 'Kultura', 'action' => 'data'));
    Router::connect('/kultura/:slug', array('plugin' => 'Kultura', 'controller' => 'Kultura', 'action' => 'file'));
    