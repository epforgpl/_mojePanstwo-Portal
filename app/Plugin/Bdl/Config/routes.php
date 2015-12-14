<?


Router::connect('/bdl/admin', array('plugin' => 'Bdl', 'controller' => 'BdlTempItems', '[method]' => 'GET', 'action' => 'index'));
Router::connect('/bdl/admin/listall', array('plugin' => 'Bdl', 'controller' => 'BdlTempItems', 'action' => 'listall'));
Router::connect('/bdl/admin/addingredients', array('plugin' => 'Bdl', 'controller' => 'BdlTempItems', 'action' => 'addingredients'));

Router::connect('/bdl/admin/:id', array('plugin' => 'Bdl', 'controller' => 'BdlTempItems', '[method]' => 'GET', 'action' => 'view'), array('pass' => array('id')));
Router::connect('/bdl/admin/:id', array('plugin' => 'Bdl', 'controller' => 'BdlTempItems', '[method]' => 'POST', 'action' => 'edit'), array('pass' => array('id')));
Router::connect('/bdl/admin', array('plugin' => 'Bdl', 'controller' => 'BdlTempItems', '[method]' => 'POST', 'action' => 'add'));
Router::connect('/bdl/admin/:id/delete', array('plugin' => 'Bdl', 'controller' => 'BdlTempItems', 'action' => 'delete'), array('pass' => array('id')));




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