<?

	Router::connect('/zamowienia_publiczne', array('plugin' => 'ZamowieniaPubliczne', 'controller' => 'ZamowieniaPubliczne', 'action' => 'view'));
	Router::connect('/zamowienia_publiczne/:action', array('plugin' => 'ZamowieniaPubliczne', 'controller' => 'ZamowieniaPubliczne'));
