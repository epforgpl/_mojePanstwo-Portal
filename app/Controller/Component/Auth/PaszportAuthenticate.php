<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');
App::import('Model', 'Paszport.User');

class PaszportAuthenticate extends BaseAuthenticate {

    public function authenticate(CakeRequest $request, CakeResponse $response) {
        $user = new User();
        $response = $user->login($request->data['User']['email'], $request->data['User']['password']);
        return $response;
    }

}