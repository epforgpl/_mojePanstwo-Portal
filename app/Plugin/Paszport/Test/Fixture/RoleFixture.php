<?php

class RoleFixture extends CakeTestFixture {

    public $import = array('model' => 'Paszport.Role');

    public $records = array(
		array(
			'id' => 1,
			'name' => 'Standard',
		),
		array(
			'id' => 2,
			'name' => 'Superuser',
		),
		array(
			'id' => 3,
			'name' => 'BDL'
		)
	);

}
