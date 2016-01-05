<?php

/**
 * ApiApp Model
 *
 */
class ApiApp extends AppModel {
    
    public $useDbConfig = 'sql_server';
    
    public $name = 'Start.ApiApp';
    public $useTable = 'api_apps';


    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Nazwa jest obowiązkowa'
            ),
        ),
        'description' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Prosimy krótko opisać jakie zbiory danych i w jakim celu będziesz wykorzystywać'
            ),
        ),
        'type' => array(
            'inList' => array(
                'rule' => array('inList', array('web', 'backend')),
                'required' => true
            ),
        ),
        'api_key' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'required' => true
            ),
        ),
        'user_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'required' => true
            ),
        )
    );

    function beforeValidate() {
        if (Validation::notEmpty(@$this->data[$this->alias]['type']) && $this->data[$this->alias]['type'] == 'web') {
            $this->validator()->add('domains', 'notEmpty', array(
                'rule' => array('notEmpty'),
                'message' => 'Należy podać domenę z jakiej będą wykonywane zapytania AJAX',
                'allowEmpty' => false,
                'required' => true
            ));
        }
        return true;
    }

    public function notEmptyForWebApp($validationFields = array()) {
        if (Validation::notEmpty(@$this->data[$this->alias]['type']) && $this->data[$this->alias]['type'] == 'web') {
            foreach ($validationFields as $key => $value) {
                if (!Validation::notEmpty($value)) {
                    return false;
                }
            }
            return true;

        } else {
            return true;
        }
    }
}
