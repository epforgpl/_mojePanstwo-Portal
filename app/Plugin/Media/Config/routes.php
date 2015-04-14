<?

Router::redirect('/panstwo_internet', '/media');
Router::redirect('/media_spolecznosciowe', '/media');
Router::redirect('/mediaspolecznosciowe', '/media');

Router::connect('/media', array('plugin' => 'Media', 'controller' => 'Media', 'action' => 'view'));
Router::connect('/media/:action', array('plugin' => 'Media', 'controller' => 'Media'));

/*
Router::connect('/panstwo_internet', array('plugin' => 'PanstwoInternet', 'controller' => 'pages', 'action' => 'home'));
Router::connect('/media_spolecznosciowe', array('plugin' => 'PanstwoInternet', 'controller' => 'pages', 'action' => 'home'));
Router::connect('/mediaspolecznosciowe', array('plugin' => 'PanstwoInternet', 'controller' => 'pages', 'action' => 'home'));
*/