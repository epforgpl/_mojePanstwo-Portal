<?php
/**
* ApiAppFixture
*
*/
class ApiAppFixture extends CakeTestFixture {

    public $import = array('model' => 'Paszport.ApiApp');

    public $records = array(
		array(
			'id' => 1,
			'name' => 'App1',
			'description' => 'Desc1',
			'type' => 'web',
			'api_key' => '123',
			'domains' => 'example1.com',
			'user_id' => 2,
		),
		array(
			'id' => 2,
			'name' => 'App2',
			'description' => 'Desc2',
			'type' => 'backend',
			'api_key' => '234',
			'user_id' => 2,
		),
		array(
			'id' => 3,
			'name' => 'App3',
			'description' => 'Desc3',
			'type' => 'web',
			'api_key' => '345',
			'domains' => '*.example2.com',
			'user_id' => 3,
		),
		array(
			'id' => 4,
			'name' => 'App4',
			'description' => 'Desc4',
			'type' => 'backend',
			'api_key' => '456',
			'user_id' => 3,
		)
	);

}
