<?php
App::uses('AppController', 'Controller');

class ApiAppsController extends PaszportAppController {

    public $components = array('Paginator');
    public $uses = array('Paszport.ApiApp', 'Paszport.User');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function getMenu()
    {
        $menu = array(
            'items' => array(),
            'base' => '/' . $this->settings['id'],
        );

        $menu['items'][] = array(
            'label' => 'Podstawowe informacje',
            'id' => '',
        );

        $menu['items'][] = array(
            'label' => 'Aplikacje',
            'id' => 'api_apps',
        );

        return $menu;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $user = $this->Auth->User();

        if (@$user['UserRole'][0]['role_id'] == 2) {
            // superuser
//            $this->Paginator->settings = array(
//                'ApiApp' => array(
//                    'recursive' => 0
//                )
//            );

            $apps = $this->Paginator->paginate();

            // fill user info
            $user_ids = array();
            foreach ($apps as $a) {
                $user_ids[$a['ApiApp']['user_id']] = 0;
            }

            $users = array();
            foreach ($this->User->find('all', array('conditions' => array(
                'User.id' => array_keys($user_ids)
            ))) as $u) {
                $users[$u['User']['id']] = $u;
            }

            foreach ($apps as &$app) {
                $u = $users[$app['ApiApp']['user_id']];
                $app['User'] = array(
                    'email' => $u['User']['email'],
                    'username' => $u['User']['username']
                );
            }

            $this->setSerialized('apiApps', $apps);

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

    public function add() {
        if ($this->request->is('post')) {

            // sanitize data
            $data = $this->request->data['ApiApp'];

            unset($data['id']);
            $data['user_id'] = $this->Auth->user('id');

            if (@$data['type'] == 'backend') {
                unset($data['domains']);
            }
            $data['api_key'] = $this->generateApiKey();

            // save
            if ($this->ApiApp->save(array('ApiApp' => $data))) {
                $this->Session->setFlash(__('The api app has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The api app could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * @return string Random SHA-1
     */
    private function generateApiKey()
    {
        return sha1(uniqid() . rand(0, PHP_INT_MAX));
    }

    public function view($id = null) {
        if (!$this->ApiApp->exists($id)) {
            throw new NotFoundException(__('Invalid api app'));
        }
        $options = array('conditions' => array('ApiApp.' . $this->ApiApp->primaryKey => $id));
        $this->set('apiApp', $this->ApiApp->find('first', $options));
    }

    public function edit($id = null) {
        $app = $this->ApiApp->read(null, $id);
        if (!$app) {
            throw new NotFoundException(__('Invalid api app'));
        }

        if ($app['ApiApp']['user_id'] != $this->Auth->user('id')) {
            throw new ForbiddenException("Cannot edit other users apps");
        }
        if ($this->request->is(array('post', 'put'))) {

            // sanitize
            $allowed_fields = array('name', 'description', 'home_link');
            if ($app['ApiApp']['type'] == 'web') {
                array_push($allowed_fields, 'domains');
            }

            $data = $this->request->data['ApiApp'];
            $data = array_intersect_key($data, array_flip($allowed_fields));

            if ($this->ApiApp->save(array('ApiApp' => $data))) {
                $this->Session->setFlash(__('The api app has been saved.'));
                return $this->redirect(array('action' => 'index'));

            } else {
                $this->Session->setFlash(__('The api app could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ApiApp.' . $this->ApiApp->primaryKey => $id));
            $this->request->data = $this->ApiApp->find('first', $options);
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

        if ($app['ApiApp']['user_id'] != $this->Auth->user('id')) {
            throw new ForbiddenException("Cannot edit other users apps");
        }

        $this->request->onlyAllow('post');

        $app['ApiApp']['api_key'] = $this->generateApiKey();
        if ($this->ApiApp->save($app)) {
            $this->Session->setFlash('Klucz API został zresetowany.');

        } else {
            throw new Exception('Klucz API powinno się zawsze udać zresetować');
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function delete($id = null) {
        $app = $this->ApiApp->read(null, $id);
        if (!$app) {
            throw new NotFoundException('Invalid id');
        }

        if ($app['ApiApp']['user_id'] != $this->Auth->user('id')) {
            throw new ForbiddenException("Cannot delete other users apps");
        }

        $this->request->onlyAllow('post', 'delete');

        $this->ApiApp->id = $id;
        if ($this->ApiApp->delete()) {
            $this->Session->setFlash(__('The api app has been deleted.'));
        } else {
            throw new Exception('Usunięcie aplikacji zawsze powinno się udać');
        }
        return $this->redirect(array('action' => 'index'));
    }
}
