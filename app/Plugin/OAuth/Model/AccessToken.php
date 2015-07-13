<?php

App::uses('OAuthAppModel', 'OAuth.Model');

/**
 * AccessToken Model
 *
 * @property Client $Client
 * @property User $User
 */
class AccessToken extends OAuthAppModel
{

    public $useTable = false;
    public $useDbConfig = 'mpAPI';

    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'oauth_token';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'oauth_token';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'oauth_token' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
            )
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
        'expires' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
    );

    public $actsAs = array(
        'OAuth.HashedField' => array(
            'fields' => 'oauth_token',
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
        )
    );

    public function schema()
    {
        return array();
    }

    public function find($type, $queryData)
    {

        $response = $this->getDataSource()->request('oauth/access_tokens/find/' . $type, array(
            'data' => $queryData,
            'method' => 'GET'
        ));

        return $response;
    }

    public function save($data)
    {

        $response = $this->getDataSource()->request('oauth/access_tokens/save/', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

}
