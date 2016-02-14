<?

Router::connect('/survey', array(
    'plugin' => 'Survey',
    'controller' => 'Survey',
    'action' => 'save',
    '[method]' => 'POST'
));
