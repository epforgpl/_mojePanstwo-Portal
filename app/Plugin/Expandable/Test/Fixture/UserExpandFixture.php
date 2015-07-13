<?php

/**
 * UserExpandFixture for ExpandableBehavior
 */
class UserExpandFixture extends CakeTestFixture
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
        'user_id' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 36,
            'key' => 'index',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'key' => array(
            'type' => 'string',
            'null' => true,
            'default' => null,
            'length' => 128,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'value' => array(
            'type' => 'text',
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'search' => array('column' => array('user_id', 'key'), 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    /**
     * Records
     *
     * @var array
     */
    public $records = array(
        array(
            'id' => '512f9a46-cedc-4929-b618-a7f3be512ef6',
            'user_id' => 1,
            'created' => '2013-02-28 12:56:22',
            'key' => 'Lorem ipsum dolor sit amet',
            'value' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
        ),
    );

}
