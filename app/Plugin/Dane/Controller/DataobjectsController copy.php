<?php

class DataobjectsController extends DaneAppController
{
    public $headerObject = false;

    public $helpers = array('Paginator');
    public $components = array('Paginator', 'RequestHandler');
    public $object = false;
    public $objectOptions = array(
        'hlFields' => false,
    );
    public $dataset = false;
    public $menu = array(
        array(
            'id' => 'view',
            'label' => 'LC_DANE_START',
        ),
    );
    public $menuMode = 'horizontal';
    public $autoRelated = true;
    public $mode = false;

    public $breadcrumbsMode = 'datachannel';

    public $initLayers = array();

    public $microdata = array(
        'itemtype' => 'http://schema.org/Intangible',
        'titleprop' => 'name',
    );

    public $search_field = 'id';

    public function index()
    {
        $this->dataobjectsBrowserView(array(
            'allowedParams' => array('q'),
        ));

        $this->set('title_for_layout', isset($this->request->query['q']) ? $this->request->query['q'] : 'Szukaj');
    }

    public function suggest()
    {

        $q = (string)@$this->request->query['q'];
        $app = (string)@$this->request->query['app'];

        if (!$q) {
            return false;
        }

        $params = array(
            'q' => $q,
        );

        if ($app)
            $params['app'] = $app;

        $data = $this->API->Dane()->suggest($params);
        $hits = array();

        foreach ($data as $d) {
            $hits[] = array(
                'date' => $d->getDate(),
                'label' => $d->getTinyLabel(),
                'title' => $d->getTitle(),
                'dataset' => $d->getDataset(),
                'id' => $d->getId(),
            );
        }

        $this->set('hits', $hits);
        $this->set('_serialize', array('hits'));

    }

    public function view()
    {
        $this->_prepareView();
    }

    public function _prepareView()
    {

        try {

            $pieces = parse_url(Router::url($this->here, true));
            $slug = (
                ($pieces['host'] != PK_DOMAIN) &&
                isset($this->params->slug)
            ) ? $this->params->slug : false;

            $this->object = $this->API->getObject($this->params->controller, $this->params->id, array(
                'layers' => $this->initLayers,
                'dataset' => true,
                'flag' => (boolean)$this->Session->read('Auth.User.id'),
                'alerts_queries' => true,
                'slug' => $slug,
                'search_field' => $this->search_field,
            ));

            // debug( $slug ); debug( $this->object->getSlug() ); die();

            $regexp = '/^\/dane\/(.*?)\/([0-9]+)';
            if ($slug)
                $regexp .= '\,' . preg_quote($slug);
            $regexp .= '(.*?)$/i';

            if (
                ($pieces['host'] != PK_DOMAIN) &&
                $this->object->getSlug() &&
                ($slug != $this->object->getSlug()) &&
                preg_match($regexp, $_SERVER['REQUEST_URI'], $match)
            ) {

                $url = '/dane/' . $match[1] . '/' . $match[2] . ',' . $this->object->getSlug() . $match[3];
                // debug( $url ); die();
                $this->redirect($url);
                die();

            }

        } catch (Exception $e) {

            $data = $e->getData();
            if ($data && isset($data['redirect']) && $data['redirect']) {

                $this->redirect('/dane/' . $data['redirect']['alias'] . '/' . $data['redirect']['object_id']);

            }
            throw new NotFoundException('Could not find that object');

        }

        if (is_object($this->object)) {

            $this->dataset = $this->object->getLayer('dataset');

            $this->set('object', $this->object);
            $this->set('objectOptions', $this->objectOptions);

            $this->set('microdata', $this->microdata);

            $this->set('_APPLICATION', $this->dataset['App']);

            $this->addStatusbarCrumb(array(
                'href' => '/dane/' . $this->object->getDataset(),
                'text' => $this->dataset['Dataset']['name'],
            ));

            $title_for_layout = $this->object->getTitle();

            $this->set('menu', $this->menu);
            $this->set('menuMode', $this->menuMode);
            $this->set('title_for_layout', $title_for_layout);

            if ($desc = $this->object->getDescription())
                $this->setMetaDescription($desc);

        } else {

            throw new NotFoundException('Could not find that object');

        }
    }

    public function prepareFeed($params = array())
    {

        $params = array_merge(array(
            'dataset' => $this->object->getDataset(),
            'id' => $this->object->getId(),
            'direction' => 'desc',
            'perPage' => 20,
        ), $params);

        if ($this->request->is('ajax'))
            $params = array_merge($params, array(
                'page' => @$this->request->query['page'],
                'perPage' => @$this->request->query['perPage'],
                'direction' => @$this->request->query['direction'],
            ));

        $this->API->feed($params);

        if ($this->request->is('ajax')) {

            $view = new View($this, false);

            $html = $view->element('Dane.DataobjectsFeed/loop', array(
                'objects' => $this->API->getObjects(),
                'preset' => $this->object->getDataset(),
            ));

            $this->set('html', $html);
            $this->set('pagination', $this->API->getPagination());
            $this->set('_serialize', array('pagination', 'html'));

        } else {

            $feed = array_merge($params, array(
                'data' => $this->API->getObjects(),
                'pagination' => $this->API->getPagination(),
            ));

            $this->set('feed', $feed);

        }

    }

    public function addInitLayers($layers)
    {

        if (is_array($layers)) {
            $this->initLayers = array_merge($this->initLayers, $layers);
        } else {
            $this->initLayers[] = $layers;
        }

    }

    public function related()
    {
        $this->_prepareView();

        if (!$this->autoRelated) {
            $this->object->loadRelated();
        }

        $this->set('showRelated', true);
        $this->view = '/Dataobjects/related';
    }

    public function beforeRender()
    {

        parent::beforeRender();

        if (is_object($this->object) && !$this->request->is('ajax') && !$this->mode) {
            $this->set('_dataset', $this->object->getDataset());
            $this->set('_object_id', $this->object->getId());
            $this->set('_data', $this->object->getData());
            $this->set('_layers', $this->object->layers);
            $this->set('_serialize', array('_dataset', '_object_id', '_data', '_layers'));
        }
        $this->set('headerObject', $this->headerObject);
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->deny(array('subscribe'));
    }

    public function subscribe($object_id)
    {

        $res = $this->Dataobject->subscribe($object_id, $this->Auth->user('id'));
        $this->set(array(
            'res' => $res,
            '_serialize' => 'res',
        ));

    }

    protected function prepareMenu()
    {
    }

}