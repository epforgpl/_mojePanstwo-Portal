<?php
App::uses('OAuthAppModel', 'OAuth.Model');

class AdminUsersGroupModel extends OAuthAppModel
{

    public $useTable = false;
    public $useDbConfig = 'mpAPI';

    /**
     * Grupy do których należy użytkownik
     *
     * @param $user_id int
     * @return array
     */
    public function getGroups($user_id) {
        return $this->getDataSource()->request('oauth/admin_users_group/get', array(
            'data' => array(
                'user_id' => $user_id
            ),
            'method' => 'GET'
        ));
    }

}