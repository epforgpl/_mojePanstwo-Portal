<?php

App::uses('ApplicationsController', 'Controller');

class PismaController extends ApplicationsController
{

    public $_layout = array(
        'header' => array(
            'element' => 'app',
        ),
        'body' => array(
            'theme' => 'default',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );


    public $settings = array(
        'id' => 'pisma',
        'title' => 'Pisma',
        'subtitle' => 'Wysyłaj pisma urzędowe do instytucje publicznych',
    );
    public $helpers = array('Form');
    public $uses = array('Pisma.Pismo', 'Sejmometr.Sejmometr');
    public $components = array('RequestHandler');
    public $appSelected = 'pisma';
    private $aggs_dict = array(
        'access' => array(
            'private' => 'Prywatne',
            'public' => 'Publiczne',
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter();
        
        if(!in_array($this->request->params['action'], array('naszrzecznik', 'patrzymynawas'))) {
        
	        if(@$this->request->params['ext'] != 'json')
	            $this->redirect('/moje-pisma');
            
        }
    }

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/pisma/img/social/pisma.jpg');
    }

    public function view($id, $slug = '')
    {
        $pismo = $this->load($id);
    }

    private function load($id)
    {

        try {

            $pismo = $this->Pismo->documents_read($id);
            $is_owner = false;

            if (
                (
                    ($this->Auth->user()) &&
                    ($pismo['from_user_type'] == 'account') &&
                    ($this->Auth->user('id') == $pismo['from_user_id'])
                ) || (
                    (!$this->Auth->user()) &&
                    ($pismo['from_user_type'] == 'anonymous') &&
                    (session_id() == $pismo['from_user_id'])
                )
            )
                $is_owner = true;

            $pismo['is_owner'] = $is_owner;

            $this->title = $pismo['name'];
            $this->set('pismo', $pismo);

            return $pismo;

        } catch (Exception $e) {

            $this->set('title_for_layout', 'Pismo nie istnieje lub nie masz do niego dostępu');
            $this->render('not_found');
            return false;

        }

    }

    public function edit($id, $slug = '')
    {

        if ($pismo = $this->load($id)) {

            if (!$pismo['is_owner'])
                return $this->redirect($this->referer());

			$this->menu_selected = 'view';

        } else {

            $this->set('title_for_layout', 'Pismo nie istnieje lub nie masz do niego dostępu');
            $this->render('not_found');

        }

    }

    public function share($id, $slug = '')
    {
        $this->load($id);
    }

    public function html($id, $slug = '')
    {

        $pismo = $this->load($id);

        $view = new View($this, false);
        $html = $view->element('html', array(
            'pismo' => $pismo,
        ));
        echo $html;
        die();
    }

    public function put($id, $slug = false)
    {

        $params = array();
        if (!$this->Auth->user())
            $params['anonymous_user_id'] = session_id();

        $status = false;

        if (isset($this->request->data['name'])) {

            $params['name'] = $this->request->data['name'];
            $status = $this->Pismo->documents_partial_update($id, $params);

        }

        $this->set('status', $status);
        $this->set('_serialize', 'status');

    }


    public function post($id = false, $slug = false)
    {

        if ($id) {

            $redirect = 'object';

            if (isset($this->request->data['delete'])) {

                $this->Pismo->documents_delete($id);
                $redirect = 'my';

            } elseif (isset($this->request->data['save'])) {

                $doc = $this->request->data;
                unset($doc['save']);

                $this->Pismo->documents_update($id, $doc);

            } elseif (isset($this->request->data['send'])) {

                if( $this->Pismo->documents_send($id, $this->request->data) ) {
                    $this->Session->setFlash('Twoje pismo zostało wysłane!', null, array('class' => 'alert-success'));
                }

            } elseif (isset($this->request->data['access'])) {

                $this->Pismo->documents_change_access($id, $this->request->data['access']);

            }

            if ($redirect == 'object') {

                $url = '/pisma/' . $id;
                if ($slug)
                    $url .= ',' . $slug;

                return $this->redirect($url);

            } elseif ($redirect == 'my') {

                return $this->redirect('/pisma');

            }

        } elseif (
            isset($this->request->data['action']) &&
            ($this->request->data['action'] == 'delete')
        ) {

            $this->Pismo->documents_delete($this->request->data['id']);
            return $this->redirect('/pisma');

        }

    }

    public function create()
    {

        $pismo = array();

        if (isset($this->request->data['adresat_id']))
            $pismo['adresat_id'] = $this->request->data['adresat_id'];

        if (isset($this->request->data['szablon_id']))
            $pismo['szablon_id'] = $this->request->data['szablon_id'];

        if (!$this->Auth->user())
            $this->Session->write('Pisma.transfer_anonymous', true);

        $status = $this->Pismo->documents_create($pismo);

        if( isset($status['error']) && $status['error'] ) {

        } else {
	        return $this->redirect($status['url'] . '/edit');
        }

    }

    public function home()
    {

        $this->menu_selected = 'nowe';
        $query = array_merge($this->request->query, $this->request->params);
		
        $pismo = array(
            'szablon_id' => isset($query['szablon_id']) ? $query['szablon_id'] : false,
            'adresat_id' => isset($query['adresat_id']) ? $query['adresat_id'] : false,
        );

        $this->set('pismo_init', $pismo);
                
        $this->title = 'Nowe pismo';

    }

    public function naszrzecznik()
    {

        $this->menu_selected = 'nowe';
        $query = array_merge($this->request->query, $this->request->params);

        $pismo = array(
            'szablon_id' => isset($query['szablon_id']) ? $query['szablon_id'] : false,
            'adresat_id' => isset($query['adresat_id']) ? $query['adresat_id'] : false,
        );

        $this->set('pismo_init', $pismo);
        $this->set('okregi', $this->Sejmometr->okregi_sejm());
        $this->title = 'Nasz Rzecznik | Pisma';
    }
    
    public function patrzymynawas()
    {

        $this->menu_selected = 'nowe';
        $query = array_merge($this->request->query, $this->request->params);

        $pismo = array(
            'szablon_id' => isset($query['szablon_id']) ? $query['szablon_id'] : false,
            'adresat_id' => isset($query['adresat_id']) ? $query['adresat_id'] : false,
        );

        $this->set('pismo_init', $pismo);
        $this->set('okregi', $this->Sejmometr->okregi_sejm());
        $this->title = 'Dołącz do apelu organizacji ws projektu ustawy o Trybunale Konstytucyjnym';
    }

    public function my()
    {
        $this->menu_selected = 'view';
        $q = false;

        $params = array(
            'page' => (
                isset($this->request->query['page']) &&
                is_numeric($this->request->query['page'])
            ) ? $this->request->query['page'] : 1,
        );

        if (
            isset($this->request->query['q']) &&
            $this->request->query['q']
        )
            $q = $params['q'] = $this->request->query['q'];

        if ($user = $this->Auth->user()) {

        } else {

            $params['anonymous_user_id'] = session_id();

        }


        $filters_selected = array();
        $allowed_vars = array('template', 'to', 'sent', 'access');

        foreach ($allowed_vars as $var) {
            if (isset($this->request->query[$var])) {
                $filters_selected[$var] = true;
                $params['conditions'][$var] = $this->request->query[$var];
            }
        }

        $search = $this->Pismo->documents_search($params);
        $performance = $search['performance'];
        $pagination = $search['pagination'];
        $items = $search['items'];
        $_aggs = $search['aggs']['all'];

        // debug($_aggs); die();

        $aggs = array();

        foreach ($_aggs['access']['filtered']['buckets'] as $bucket) {
            $aggs['access']['buckets'][] = array(
                'key' => $bucket['key'],
                'label' => $this->aggs_dict['access'][$bucket['key']],
                'count' => $bucket['doc_count'],
            );
        }

        foreach ($_aggs['to_dataset']['filtered']['buckets'] as $dataset_bucket) {
            foreach ($dataset_bucket['to_id']['buckets'] as $id_bucket) {
                $aggs['to']['buckets'][] = array(
                    'key' => $dataset_bucket['key'] . ':' . $id_bucket['key'],
                    'label' => $id_bucket['to_name']['buckets'][0]['key'],
                    'count' => $id_bucket['doc_count'],
                );
            }
        }

        foreach ($_aggs['template_id']['filtered']['buckets'] as $bucket) {
            $aggs['template']['buckets'][] = array(
                'key' => $bucket['key'],
                'label' => $bucket['template_label']['buckets'][0]['key'],
                'count' => $bucket['doc_count'],
            );
        }

        foreach ($_aggs['sent']['filtered']['buckets'] as $bucket) {

            if ($bucket['key'] == 'F') {
                $aggs['sent']['buckets'][] = array(
                    'key' => '0',
                    'label' => 'Niewysłane',
                    'count' => $bucket['doc_count'],
                );
            } elseif ($bucket['key'] == 'T') {
                $aggs['sent']['buckets'][] = array(
                    'key' => '1',
                    'label' => 'Wysłane',
                    'count' => $bucket['doc_count'],
                );
            }


        }

        // debug( $aggs ); die();

        $this->set('query', $this->request->query);
        $this->set('performance', $performance);
        $this->set('pagination', $pagination);
        $this->set('items', $items);
        $this->set('aggs', $aggs);
        $this->set('q', $q);
        $this->set('title_for_layout', 'Pisma');
        $this->set('filters_selected', $filters_selected);

        $this->title = 'Moje Pisma';
    }

    public function getMenu()
    {

        $menu = array(
            'items' => array(
                array(
                    'label' => 'Moje pisma',
                ),
                array(
                    'id' => 'nowe',
                    'label' => 'Nowe pismo',
                ),
            ),
            'base' => '/pisma',
        );

        return $menu;

    }

    /*
    public function save()
    {

        if (isset($this->request->data['send'])) {


            $pismo = $this->Pismo->save($this->request->data);
            if ($pismo && isset($pismo['id']) && $pismo['id']) {

                $this->redirect($pismo['url']);

            }

        } elseif (isset($this->request->data['save'])) {

            $pismo = $this->Pismo->save($this->request->data);
            if ($pismo && isset($pismo['id']) && $pismo['id']) {

                $this->redirect($pismo['url']);

            }

        } elseif (isset($this->request->data['print'])) {

            $pismo = $this->Pismo->generatePDF($this->request->data);

        }

    }

    private function saveForm($data)
    {
        try {
            $doc = $this->api->document_save($data);

        } catch (MP\ApiValidationException $ex) {

            // TODO nie widać flash w layoucie
            $this->Session->setFlash('Wystąpiły błędy walidacji', null, array('class' => 'alert-error'));
            $this->set('verr', $ex->getValidationErrors());
            $this->set('doc', $data);
            $this->render('edit');

            return null;
        }

        if (isset($data['saveAndSend'])) {
            $this->api->document_send($doc['id']);
        }

        return $doc;
    }
    */

}
