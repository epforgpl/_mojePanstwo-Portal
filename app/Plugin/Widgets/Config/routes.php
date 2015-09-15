<?

Router::connect('/widgets/:controller/:id', array(
    'plugin' => 'Widgets',
    'action' => 'view',
), array(
    'id' => '[0-9]+',
    'pass' => array('id')
));
