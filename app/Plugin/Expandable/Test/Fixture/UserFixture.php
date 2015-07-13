<?php

/**
 * UserFixture for ExpandableBehavior
 */
class UserFixture extends CakeTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 36,
            'key' => 'primary',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'email' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 128,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'password' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 60),
        'name' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 128,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'login' => array('column' => array('is_active', 'email'), 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
    );

    /**
     * Records
     *
     * @var array
     */
    public $records = array(
        array(
            'id' => 'user-1',
            'email' => 'user1@aud.com',
            'password' => 'nonhashedpassword',
            'name' => 'first last',
            'created' => '2013-02-22 13:21:37',
            'modified' => '2013-02-22 13:21:37',
        ),
    );

}
