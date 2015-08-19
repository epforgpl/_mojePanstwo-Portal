<?

Router::mapResources('Bdl.BdlTempItems', array(
	'prefix' => '/bdl/',
	'plugin' => 'BDL',
));

Router::connect('/bdl/bdl_temp_items/:item_id/ingredients', array('plugin' => 'Bdl', 'controller' => 'BdlTempItems', 'action' => 'addIngredient'), array(
	'item_id' => '([0-9]+)',
	'pass' => array('item_id'),
));


Router::connect('/bdl', array('plugin' => 'Bdl', 'controller' => 'Bdl', 'action' => 'view'));
Router::connect('/bdl/:action', array('plugin' => 'Bdl', 'controller' => 'Bdl'));
Router::connect('/bdl/:action/:id', array('plugin' => 'Bdl', 'controller' => 'Bdl'), array(
	'id' => '([0-9]+)',
	'pass' => array('id'),
));