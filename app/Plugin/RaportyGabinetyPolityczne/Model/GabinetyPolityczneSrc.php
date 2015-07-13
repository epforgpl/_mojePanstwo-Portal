<?php
App::uses('AppModel', 'Model');

/**
 * PlGabinetyPolityczneSrc Model
 *
 * @property SPodmioty $SPodmioty
 */
class GabinetyPolityczneSrc extends AppModel
{

    /**
     * Use database config
     *
     * @var string
     */
    public $useDbConfig = 'raporty';

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'pl_gabinety_polityczne_src';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'RaportyGabinetyPolityczne.SPodmioty' => array(
            'className' => 'SPodmioty',
            'foreignKey' => 's_podmioty_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}
