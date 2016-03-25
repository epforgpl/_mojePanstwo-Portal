<?

Router::redirect('/panstwo_internet', '/media');
Router::redirect('/media_spolecznosciowe', '/media');
Router::redirect('/mediaspolecznosciowe', '/media');

Router::redirect('/media/twitter/suggestNewAccount', array('plugin' => 'Media', 'controller' => 'Twitter', 'action' => 'suggestNewAccount'));

Router::connect('/media', array('plugin' => 'Media', 'controller' => 'Media', 'action' => 'view'));
Router::connect('/media/propozycje_kont', array('plugin' => 'Media', 'controller' => 'Media', 'action' => 'propozycje_kont', '[method]' => 'GET'));
Router::connect('/media/propozycje_kont', array('plugin' => 'Media', 'controller' => 'Media', 'action' => 'manage_account', '[method]' => 'POST'));
Router::connect('/media/:id', array('plugin' => 'Media', 'controller' => 'Media', 'action' => 'view',), array(
	'id' => 'politycy|ngo|komentatorzy|urzedy|miasta|media|partie'
));
Router::connect('/media/usuniete', array('plugin' => 'Media', 'controller' => 'Media', 'action' => 'usuniete',));
Router::connect('/media/:id', array('plugin' => 'Media', 'controller' => 'Media', 'action' => 'action',));

/*
Router::connect('/panstwo_internet', array('plugin' => 'PanstwoInternet', 'controller' => 'pages', 'action' => 'home'));
Router::connect('/media_spolecznosciowe', array('plugin' => 'PanstwoInternet', 'controller' => 'pages', 'action' => 'home'));
Router::connect('/mediaspolecznosciowe', array('plugin' => 'PanstwoInternet', 'controller' => 'pages', 'action' => 'home'));
*/
