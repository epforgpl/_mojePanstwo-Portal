<?php
App::uses('Sanitize', 'Utility');

class GroupsController extends PowiadomieniaAppController
{
    public $uses = array();
    public $components = array(
        'Session',
        'RequestHandler',
    );

    public function index()
    {


        $queryData = array(
            'conditions' => array(
                'mode' => 1,
            ),
            'limit' => 0,
            'paramType' => 'querystring',
            'page' => 1,
        );

        $this->API->_search($queryData);

        $groups = $this->API->getGroups();
        if (@$this->request->params['ext'] == 'json') {

            $html = '';
            if (!empty($groups)) {

                $view = new View($this, false);
                $html = $view->element('groups', array(
                    'groups' => $groups,
                ));

            }

            $this->set('html', $html);
            $this->set('_serialize', 'html');


        } else {

            $groups = $this->API->getGroups();
            $this->set('groups', $groups);

        }

    }

    public function view()
    {

        $group = $this->API->getGroup($this->request->params['id']);

        $this->set('group', $group);
        $this->set('_serialize', array('group'));

    }

    public function add()
    {

        $data = $this->request->data;
        $status = $this->API->saveGroup($data);

        $this->set('status', $status);
        $this->set('_serialize', 'status');

    }

    public function edit($id)
    {

        $data = $this->request->data;
        $data['group']['PowiadomieniaGroup']['id'] = $id;

        $status = $this->API->saveGroup($data);

        $this->set('status', $status);
        $this->set('_serialize', 'status');

    }

    public function delete($id = null)
    {
        if (!is_null($id)) {
            $this->API->removeGroup($id);
            // $this->Session->setFlash(__d('powiadomienia', 'LC_POWIADOMIENIA_FRAZA_ZOSTALA_USUNIETA', true));
            $this->redirect(array('controller' => 'powiadomienia', 'action' => 'index'));
        } else {
            throw new BadRequestException(__d('powiadomienia', 'LC_POWIADOMIENIA_BRAK_ID_DO_USUNIECIA', true));
        }
    }
} 