<?php

App::uses('OAuthAppModel', 'OAuth.Model');

/**
 * RefreshToken Model
 *
 * @property Client $Client
 * @property User $User
 */
class RefreshToken extends OAuthAppModel
{

    public $useTable = false;
    public $useDbConfig = 'mpAPI';

    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'refresh_token';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'refresh_token';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'refresh_token' => array(
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
            'fields' => 'refresh_token',
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
        /*$api = mpapiComponent::getApi()->OAuth()->RefreshToken();

        return $api->find($type, $queryData); */
        return $this->getDataSource()->request('oauth/refresh_tokens/find/' . $type, array(
            'data' => $queryData,
            'method' => 'POST'
        ));
    }

    public function save($data)
    {
        /*$api = mpapiComponent::getApi()->OAuth()->RefreshToken();

        return $api->save($data);*/
        $response = $this->getDataSource()->request('oauth/refresh_tokens/save/', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

}
