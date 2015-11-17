<?php

class UserFixture extends CakeTestFixture {

    public $import = array('model' => 'Paszport.User');

    public $records = array(
		array(
			'id' => 1,
			'email' => 'superuser@example.com',
			'username' => 'Superuser',
		),
		array(
			'id' => 2,
			'email' => 'ziomek2@example.com',
			'username' => 'Ziomek 2',
		),
		array(
			'id' => 3,
			'email' => 'ziomek3@example.com',
			'username' => 'Ziomek 3',
		)
	);

}
