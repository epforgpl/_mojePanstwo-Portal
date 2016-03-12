<?

    Router::connect('/srodowisko', array('plugin' => 'Srodowisko', 'controller' => 'Srodowisko', 'action' => 'view'));
    Router::connect('/srodowisko/dane', array('plugin' => 'Srodowisko', 'controller' => 'Srodowisko', 'action' => 'dane',));
    Router::connect('/srodowisko/chart', array('plugin' => 'Srodowisko', 'controller' => 'Srodowisko', 'action' => 'chart',));
    Router::connect('/srodowisko/ranking', array('plugin' => 'Srodowisko', 'controller' => 'Srodowisko', 'action' => 'ranking',));
    Router::connect('/srodowisko/:id', array('plugin' => 'Srodowisko', 'controller' => 'Srodowisko', 'action' => 'action',));

