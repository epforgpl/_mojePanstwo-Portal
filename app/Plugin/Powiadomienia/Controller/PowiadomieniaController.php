<?php

class PowiadomieniaController extends PowiadomieniaAppController
{
    public $components = array(
        'RequestHandler', 'Paginator'
    );

    public $uses = array('Powiadomienia.Dataobject');

    public $paginate = array(
        'limit' => 20,
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!$this->Auth->loggedIn() && $this->params->action != 'permissions') {
            $this->redirect(array('action' => 'permissions'));
        }
    }

    public function permissions()
    {

    }

    public function index()
    {

        // echo "index"; die();
        // FETCHING OBJECTS
        
        $group_id = isset($this->request->query['group_id']) ? $this->request->query['group_id'] : false;
        if( !$group_id )
        	$group_id = isset($this->request->query['groupid']) ? $this->request->query['groupid'] : false;
        
        $queryData = array(
            'conditions' => array(
                'group_id' => $group_id,
                'mode' => isset($this->request->query['mode']) ? $this->request->query['mode'] : false,
            ),
            'limit' => 20,
            'paramType' => 'querystring',
            'page' => isset($this->request->query['page']) ? $this->request->query['page'] : 1,
        );

        $this->API->_search($queryData);
        $objects = $this->API->getObjects();
        $this->set('objects', $objects);


        if (@$this->request->params['ext'] == 'json') {

            $html = '';
            if (!empty($objects)) {
                $view = new View($this, false);
                $html = $view->element('objects', array(
                    'objects' => $objects,
                ));
            }

            $this->set('html', $html);
            $this->set('_serialize', 'html');


        } else {

            $groups = $this->API->getGroups();
            $this->set('groups', $groups);

        }

    }

    public function flagObjects()
    {

        $object_id = (int)@$this->request->query['id'];

        if ($object_id && $this->Session->read('Auth.User.id'))
            $status = $this->API->Powiadomienia()->flagObject($object_id);

        $this->set('status', $status);
        $this->set('_serialize', 'status');

    }

}