<?php
App::uses('AppModel', 'Model');

/**
 * PlGabinetyPolityczneOsoby Model
 *
 */
class GabinetyPolityczneOsoby extends AppModel
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
    public $useTable = 'pl_gabinety_polityczne_osoby';

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
