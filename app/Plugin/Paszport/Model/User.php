<?php

class User extends PaszportAppModel
{
    public $belongsTo = array('Paszport.Language', 'Paszport.Group');
    public $hasAndBelongsToMany = array('Paszport.Service');
    public $hasMany = array('Paszport.Key', 'Paszport.UserExpand');
    public $actsAs = array('Containable', 'Expandable.Expandable' => array('with' => 'Paszport.UserExpand'));
    public $name = 'Paszport.User';
    public $useTable = false;
    public $useDbConfig = 'mpAPI';

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validator()->add('username', array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => __d('paszport', 'LC_PASZPORT_USERNAME_MUST_BE_UNIQUE', true),
            ),
            'alpha' => array(
                'rule' => 'alphaNumeric',
                'message' => __d('paszport', 'LC_PASZPORT_ALPHANUMERIC', true)
            ),
        ));

        $this->validator()->add('email', array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => __d('paszport', 'LC_PASZPORT_EMAIL_MUST_BE_UNIQUE', true)
            ),
            'email' => array(
                'rule' => 'email',
                'message' => __d('paszport', 'LC_PASZPORT_NOT_A_VALID_EMAIL', true),
            ),
        ));

        $this->validator()->add('password', array(
            'rule' => array('minLength', 6),
            'message' => __d('paszport', 'LC_PASZPORT_PASSWORD_REQUIRED_AND_LENGTH', true),
        ));

        $this->validator()->add('repassword', array(
            'rule' => array('confirmPassword'),
            'message' => __d('paszport', 'LC_PASZPORT_PASSWORDS_DONT_MATCH', true),
        ));

        $this->validator()->add('facebook_id', array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => __d('paszport', 'LC_PASZPORT_FACEBOOK_ID_NOT_UNIQUE', true),
            )
        ));

        $this->validator()->add('twitter_id', array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => __d('paszport', 'LC_PASZPORT_TWITTER_ID_NOT_UNIQUE', true),
            )
        ));

//        $this->validator()->add('personal_name', array(
//            'rule' => 'notEmpty',
//            'message' => __d('paszport','LC_PASZPORT_NAME_REQUIRED', true),
//        ));
//
//        $this->validator()->add('personal_lastname', array(
//            'rule' => 'notEmpty',
//            'message' => __d('paszport','LC_PASZPORT_LASTNAME_REQUIRED', true)
//        ));

//        $this->validator()->add('institution_name', array(
//            'rule' => 'notEmpty',
//            'message' => __d('paszport','LC_PASZPORT_INSTITUTION_NAME_REQUIRED', true)
//        ));

        $this->validator()->add('photo', array(
            'isValid' => array(
                'rule' => array('isValidMimeType', array('image/png', 'image/jpeg', 'image/jpg', 'image/gif')),
                'message' => __d('paszport', 'LC_PASZPORT_AVATAR_BAD_FILE_FORMAT', true),
            ),
        ));
    }

    /**
     * Check if user is post import and has logged before
     * if he did, that means he misspeled his passowrd | email
     * if he did not that means we need to let him in
     *
     * This is only for sejmometr as it's the only functioning service for now
     *
     * @param $data
     * @param $hashed_pass
     *
     * @return array|bool
     */
    public function checkAndLoginAgainstPostImport($data, $hashed_pass)
    {
        $password = (sha1($data['User']['email'] . SEJMOMETR_USERS_SALT . $data['User']['password']));
        $usr = $this->find('first', array(
            'conditions' => array(
                'User.email' => $data['User']['email'],
                'User.password' => $password,
                'User.source' => 'sejmometr'
            )
        ));
        if ($usr) {
            $this->id = $usr['User']['id'];
            $this->save(array(
                'password' => $hashed_pass,
                'password_set' => 1,
                'logged_before' => 1,
                'language_id' => 1,
            ));

            return $usr['User'];
        } else {
            return false;
        }
    }

    public function find($type, $conditions)
    {
        $response = $this->getDataSource()->request('paszport/user/find', array(
            'data' => array(
                'type' => $type,
                'conditions' => $conditions
            ),
            'method' => 'POST'
        ));

        return $response;
    }

    /**
     * Additional validation for password confirmation
     *
     * @param string $check
     *
     * @return bool
     */
    public function confirmPassword($check)
    {
        if (is_array($check)) {
            $check = array_pop($check);
        }
        if ($check === $this->data['User']['password']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Loguje za pomocą twittera
     * jesli user z danym twitter_id juz istnieje to go poprostu loguje
     * jesli nie to go rejestruje
     *
     * @param array $user_data
     *
     * @return array
     */
    public function twitter($user_data)
    {
        # check if user already exists;
        $exists = $this->find('first', array('conditions' => array('User.twitter_id' => $user_data['id'])));
        if ($exists) {
            return $exists['User'];
        } else {
            $this->Behaviors->load('Upload.Upload', array('photo' => array('path' => '{ROOT}webroot{DS}uploads{DS}{model}{DS}{field}{DS}')));
            $create = array(
                'User' => array(
                    'email' => $user_data['screen_name'] . '@user.twitter.com',
                    'password' => AuthComponent::password(md5($user_data['id'] . rand(0, 999) . $user_data['screen_name'])),
                    'twitter_id' => $user_data['id'],
                    'source' => 'twitter',
                    'photo' => preg_replace('/_normal/', '', $user_data['profile_image_url']),
                    'group_id' => 1,
                    'password_set' => 0,

                ),
            );
            if ($this->save($create)) {
                $this->UserExpand->save(array(
                        'UserExpand' => array(
                            'user_id' => $this->id,
                            'key' => 'username',
                            'value' => $user_data['screen_name'],
                        )
                    )
                );

                return $this->data['User'];
            }
        }

    }

    public function login($email, $password)
    {
        return $this->getDataSource()->login($email, $password);
    }

    public function read($uid)
    {
        return $this->getDataSource()->request('paszport/users/read', array('data' => array('user_id' => $uid)));
    }

    public function canCreatePassword() {
        $response = $this->getDataSource()->request('paszport/user/canCreatePassword', array(
            'data' => array(),
            'method' => 'POST'
        ));

        return $response;
    }

    public function setIsNgo($isNgo) {
        return $this->getDataSource()->request('paszport/user/setIsNgo', array(
            'data' => array(
                'is_ngo' => $isNgo
            ),
            'method' => 'POST'
        ));
    }

    public function setUserName($username)
    {
        $response = $this->getDataSource()->request('paszport/user/setUserName', array(
            'data' => array(
                'value' => $username
            ),
            'method' => 'POST'
        ));

        return $response;
    }

    public function registerFromFacebook($userData)
    {
        $response = $this->getDataSource()->request('paszport/user/registerFromFacebook', array(
            'data' => $userData,
            'method' => 'POST'
        ));

        return $response;
    }

    public function findFacebookUser($facebook_id, $email)
    {
        $response = $this->getDataSource()->request('paszport/user/findFacebook', array(
            'data' => array(
                'facebook_id' => $facebook_id,
                'email' => $email
            ),
            'method' => 'POST'
        ));

        return $response;
    }

    public function setEmail($email)
    {
        $response = $this->getDataSource()->request('paszport/user/setEmail', array(
            'data' => array(
                'value' => $email
            ),
            'method' => 'POST'
        ));

        return $response;
    }

    public function setPassword($data)
    {
        $response = $this->getDataSource()->request('paszport/user/setPassword', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

    public function createNewPassword($data)
    {
        $response = $this->getDataSource()->request('paszport/user/createNewPassword', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

    public function deletePaszport($password)
    {
        $response = $this->getDataSource()->request('paszport/user/deletePaszport', array(
            'data' => array(
                'password' => $password
            ),
            'method' => 'POST'
        ));

        return $response;
    }

    /**
     * Walidacja adresu e-mail
     * Wysyłanie wiadomości z linkiem do zmiany hasła
     *
     * @param $data
     * @return mixed
     */
    public function forgot($data)
    {
        $response = $this->getDataSource()->request('paszport/user/forgot', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

    /**
     * Walidacja tokenu zmiany hasła
     *
     * @param $data
     * @return mixed
     */
    public function forgotToken($data)
    {
        $response = $this->getDataSource()->request('paszport/user/forgotToken', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

    /**
     * Wysyłanie nowego hasła
     * Zmiana hasła użytkownika
     *
     * @param $data
     * @return mixed
     */
    public function forgotNewPassword($data)
    {
        $response = $this->getDataSource()->request('paszport/user/forgotNewPassword', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

    public function register($data)
    {
        return $this->getDataSource()->register($data);
    }

    public function getUsersByEmail($data) {
        $response = $this->getDataSource()->request('paszport/users/email.json', array(
            'data' => $data,
            'method' => 'POST'
        ));

        return $response;
    }

    public function schema()
    {
        return array();
    }

    public function getModals() {
        return $this->getDataSource()->request('users/modals.json', array(
            'method' => 'GET'
        ));
    }

    public function addModal($data) {
        return $this->getDataSource()->request('users/modals.json', array(
            'data' => $data,
            'method' => 'POST'
        ));
    }

}