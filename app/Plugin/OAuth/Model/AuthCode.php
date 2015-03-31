<?php

App::uses('OAuthAppModel', 'OAuth.Model');

/**
 * AuthCode Model
 *
 * @property Client $Client
 * @property User $User
 */
class AuthCode extends OAuthAppModel
{

    public $useTable = false;
    public $useDbConfig = 'mpAPI';

    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'code';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'code';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
            ),
        ),
        'client_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'user_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'redirect_uri' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'expires' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
    );

    public $actsAs = array(
        'OAuth.HashedField' => array(
            'fields' => 'code',
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Client' => array(
            'className' => 'OAuth.Client',
            'foreignKey' => 'client_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function schema()
    {
        return array();
    }

    public function save($data)
    {
        /* $api = mpapiComponent::getApi()->OAuth()->AuthCode();
        $ret = $api->save($data);
        return $ret; */

        $response = $this->getDataSource()->request('oauth/auth_codes/save/', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

    public function findByCode($code)
    {
        /*$api = mpapiComponent::getApi()->OAuth()->AuthCode();

        return $api->findByCode($code);*/

        $response = $this->getDataSource()->request('oauth/refresh_tokens/find/' . $code, array(
            'data' => array(),
            'method' => 'POST'
        ));

        return $response;
    }


}
