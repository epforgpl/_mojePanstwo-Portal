<?php

class UserRoleFixture extends CakeTestFixture {

    public $import = array('model' => 'Paszport.UserRole');

    public $records = array(
		array(
			'user_id' => 1,
			'role_id' => 2 // superuser
		),
	);

}
