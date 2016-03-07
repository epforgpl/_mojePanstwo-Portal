<?

    Router::connect('/srodowisko', array('plugin' => 'Srodowisko', 'controller' => 'Srodowisko', 'action' => 'view'));
    Router::connect('/srodowisko/dane', array('plugin' => 'Srodowisko', 'controller' => 'Srodowisko', 'action' => 'dane',));
    Router::connect('/srodowisko/:id', array('plugin' => 'Srodowisko', 'controller' => 'Srodowisko', 'action' => 'action',));

