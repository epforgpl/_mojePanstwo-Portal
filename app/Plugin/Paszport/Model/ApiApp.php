<?php
App::uses('PaszportAppModel', 'Paszport.Model');

/**
 * ApiApp Model
 *
 */
class ApiApp extends AppModel {
    public $name = 'Paszport.ApiApp';
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
                'required' => true
            ),
        ),
        'description' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'required' => true
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
                'message' => 'Domains are required for web application',
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
