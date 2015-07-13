<?php
App::uses('AppModel', 'Model');

/**
 * SPodmioty Model
 *
 * @property PlGabinetyPolityczneOsoby $PlGabinetyPolityczneOsoby
 * @property PlGabinetyPolityczneSrc $PlGabinetyPolityczneSrc
 */
class SPodmioty extends AppModel
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
    public $useTable = 's_podmioty';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'nazwa';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'RaportyGabinetyPolityczne.GabinetyPolityczneOsoby' => array(
            'className' => 'GabinetyPolityczneOsoby',
            'foreignKey' => 's_podmioty_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    public $hasOne = array(
        'RaportyGabinetyPolityczne.GabinetyPolityczneSrc' => array(
            'className' => 'GabinetyPolityczneSrc',
            'foreignKey' => 's_podmioty_id'
        )
    );

}
