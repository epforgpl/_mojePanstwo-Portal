<?php

class PowiadomieniaController extends PowiadomieniaAppController
{
    public $components = array(
        'RequestHandler',
        'Paginator'
    );

    public function index()
    {
        $group_id = isset($this->request->query['group_id']) ? $this->request->query['group_id'] : false;
        if (!$group_id) {
            $group_id = isset($this->request->query['groupid']) ? $this->request->query['groupid'] : false;
        }

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
        $groups = $this->API->getGroups();

        $this->set('objects', $objects);
        $this->set('groups', $groups);


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


        }

        $this->set('appMenuSelected', 'jak_to_dziala');
    }
}