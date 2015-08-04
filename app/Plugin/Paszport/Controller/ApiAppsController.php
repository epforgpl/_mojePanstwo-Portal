<?php
App::uses('AppController', 'Controller');

class ApiAppsController extends PaszportAppController {

    public $components = array('Paginator');
    public $uses = array('Paszport.ApiApp', 'Paszport.User');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $user = $this->Auth->User();

        if ($user['UserRole'][0]['role_id'] == 2) {
            // superuser
//            $this->Paginator->settings = array(
//                'ApiApp' => array(
//                    'recursive' => 0
//                )
//            );

            $user_ids = array();
            $apps = array();
            foreach($this->Paginator->paginate() as $a) {
                $app = array_intersect_key($a['ApiApp'], array_flip(array(
                    'id', 'name', 'description', 'home_link', 'type', 'api_key', 'domains', 'user_id'
                )));

                $user_ids[$app['user_id']] = 0;
                $apps[] =  $app;
            }

            // fill user info
            $users = array();
            foreach ($this->User->find('all', array('conditions' => array(
                'User.id' => array_keys($user_ids)
            ))) as $u) {
                $users[$u['User']['id']] = $u;
            }

            foreach ($apps as $app) {
                $u = $users[$app['user_id']];
                $app['user'] = array(
                    'email' => $u['User']['email'],
                    'username' => $u['User']['username']
                );
            }

            $this->setSerialized('apps', $apps);

        } else {
            $this->Paginator->settings = array(
                'ApiApp' => array(
                    'conditions' => array(
                        'user_id' => $this->Auth->user('id')
                    ),
                    'recursive' => -1
                ));

            $apps = array_map(function ($a) {
                return array_intersect_key($a['ApiApp'], array_flip(array(
                    'id', 'name', 'description', 'home_link', 'type', 'api_key', 'domains'
                )));
            }, $this->Paginator->paginate());

            $this->setSerialized('apiApps', $apps);
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $user = $this->Auth->User();

        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (@$data['user_id'] != $$user['id']) {
                throw new ForbiddenException("It's forbidden to create apps for other users");
            }

            unset($data['id']);
            if (@$data['type'] == 'backend') {
                unset($data['domains']);
            }
            $data['api_key'] = $this->generateApiKey();

            $this->ApiApp->create($data);
            if ($this->ApiApp->save()) {
                // TODO response 201
                $data['id'] = $this->ApiApp->id;
                $this->setSerialized('apiApp', $data);

            } else {
                throw new ValidationException($this->ApiApp->validationErrors);
            }
        } else {
            throw new BadRequestException();
        }
    }

    public function view($id) {
        $app = $this->ApiApp->read(null, $id);
        if (!$app) {
            throw new NotFoundException(__('Invalid api app'));
        }

        $this->setSerialized('app', $app);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id) {
        $app = $this->ApiApp->read(null, $id);
        if (!$app) {
            throw new NotFoundException(__('Invalid api app'));
        }

        if ($app['user_id'] != $this->Auth->user('id')) {
            throw new ForbiddenException("Cannot edit other users apps");
        }

        if ($this->request->is(array('post', 'put'))) {
            $allowed_fields = array('name', 'description');
            if ($app['type'] == 'web') {
                array_push($allowed_fields, 'domains');
            }

            $data = $this->request->data;
            if (isset($data['type']) && $app['type'] != $data['type']) {
                throw new ForbiddenException("Cannot change app type");
            }

            $data = array_merge($data, array_flip($allowed_fields));
            $this->ApiApp->save($data); // TODO errors?
        } else {
            throw new BadRequestException();
        }
    }

    /**
     * reset api key
     */
    public function reset_api_key($id = null) {
        $app = $this->ApiApp->read(null, $id);
        if (!$app) {
            throw new NotFoundException('Invalid id');
        }

        if ($app['user_id'] != $this->Auth->user('id')) {
            throw new ForbiddenException("Cannot edit other users apps");
        }

        $app['api_key'] = $this->generateApiKey();
        $this->ApiApp->save($app);

        $this->setSerialized($app);
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $app = $this->ApiApp->read(null, $id);
        if (!$app) {
            throw new NotFoundException('Invalid id');
        }

        if ($app['user_id'] != $this->Auth->user('id')) {
            throw new ForbiddenException("Cannot delete other users apps");
        }

        $this->ApiApp->id = $id;
        $this->request->onlyAllow('post', 'delete');
        if ($this->ApiApp->delete()) {
            // TODO return 204?
        } else {
            throw new InternalErrorException('Why? Why?');
        }
    }

    /**
     * @return string Random SHA-1
     */
    private function generateApiKey() {
        return sha1(uniqid() . rand(0, PHP_INT_MAX));
    }
}
