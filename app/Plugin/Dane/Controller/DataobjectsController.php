<?

class DataobjectsController extends AppController
{

    public $uses = array('Dane.Dataobject', 'Dane.Subscription');
    public $components = array('RequestHandler');

    public $object = false;
    public $initLayers = array();
    public $initAggs = array();
    public $objectOptions = array(
        'hlFields' => false,
    );
    public $loadChannels = false;
    public $channels = array();

    public $microdata = array(
        'itemtype' => 'http://schema.org/Intangible',
        'titleprop' => 'name',
    );

    public $actions = array();
    public $appSelected = '';
    public $addDatasetBreadcrumb = true;

    public $_layout = array(
        'header' => array(
            'element' => 'dataobject',
        ),
        'body' => array(
            'theme' => 'default'
        )
    );

    public function addInitLayers($layers)
    {

        if (is_array($layers)) {
            $this->initLayers = array_merge($this->initLayers, $layers);
        } else {
            $this->initLayers[] = $layers;
        }

    }

    public function addInitAggs($aggs = false)
    {
        $this->initAggs = $aggs;
    }

    public function _prepareView()
    {
        return $this->load();
    }

    public function load()
    {

        $dataset = isset($this->request->params['controller']) ? $this->request->params['controller'] : false;
        $id = isset($this->request->params['id']) ? $this->request->params['id'] : false;
        $slug = isset($this->request->params['slug']) ? $this->request->params['slug'] : '';

        // debug(array('dataset' => $dataset, 'id' => $id, 'slug' => $slug, )); die();

        if (
            $dataset &&
            $id &&
            is_numeric($id)
        ) {

            $layers = $this->initLayers;

            if ($this->observeOptions)
                $layers[] = 'channels';

            if ($this->object = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => $dataset,
                    'id' => $id,
                ),
                'layers' => $layers,
                'aggs' => $this->initAggs,
            ))
            ) {

                $this->set('object_aggs', $this->Dataobject->getAggs());

                if (
                    ($this->domainMode == 'MP') &&
                    (
                        !isset($this->request->params['ext']) ||
                        !in_array($this->request->params['ext'], array('json'))
                    ) &&
                    !$slug &&
                    $this->object->getSlug() &&
                    ($this->object->getSlug() != $slug) &&
                    $this->object->getUrl()
                ) {

                    $url = $this->object->getUrl();

                    if (
                        isset($this->request->params['action']) &&
                        ($this->request->params['action']) &&
                        ($this->request->params['action'] != 'view')
                    ) {

                        $url .= '/' . $this->request->params['action'];

                        if (
                            isset($this->request->params['subid']) &&
                            ($this->request->params['subid'])
                        ) {

                            $url .= '/' . $this->request->params['subid'];

                            if (
                                isset($this->request->params['subaction']) &&
                                ($this->request->params['subaction'])
                            ) {

                                $url .= '/' . $this->request->params['subaction'];

                                if (
                                    isset($this->request->params['subsubid']) &&
                                    ($this->request->params['subsubid'])
                                ) {

                                    $url .= '/' . $this->request->params['subsubid'];

                                }

                            }

                        }

                    }

                    if (
                    !empty($this->request->query)
                    )
                        $url .= '?' . http_build_query($this->request->query);

                    return $this->redirect($url);

                }

                $dataset = $this->object->getLayer('dataset');

                $this->set('object', $this->object);
                $this->set('object_subscriptions', $this->object->getLayer('subscriptions'));
                $this->set('objectOptions', $this->objectOptions);
                $this->set('microdata', $this->microdata);
                $this->set('title_for_layout', $this->object->getTitle());

            }

        } else {
            throw new BadRequestException();
        }

    }

    public function suggest()
    {
        $hits = array();

        if (isset($this->request->query['q']) && ($q = trim($this->request->query['q']))) {
            $params = array(
                'dataset' => false,
            );

            if (isset($this->request->query['dataset']) && ($dataset = $this->request->query['dataset']))
                $params['dataset'] = $dataset;

            $hits = $this->Dataobject->suggest($q, $params);
        }

        $this->set('hits', $hits);
        $this->set('_serialize', 'hits');
    }

    public function view()
    {
        $this->load();
    }

    public function feed($params = array())
    {

        if (!is_array($params))
            $params = array();

        $this->loadChannels = true;

        if ($this->object === false)
            $this->load(array(
                'subscriptions' => true,
            ));

        $params = array_merge(array(
            'feed' => $this->object->getDataset() . '/' . $this->object->getId(),
            'preset' => $this->object->getDataset(),
        ), $params);

        if (isset($params['searchTitle']))
            $_params['searchTitle'] = $params['searchTitle'];

        $this->Components->load('Dane.DataFeed', $params);

    }


    public function beforeRender()
    {

        $is_json = (isset($this->request->params['ext']) && $this->request->params['ext'] == 'json');

        if (!$is_json) {

            if (
                ($this->request->params['controller'] == 'Datasets') &&
                ($breadcrumbs_data = $this->getDataset($this->object->getData('slug')))
            ) {

                $this->addAppBreadcrumb($breadcrumbs_data['app_id']);

            } elseif ($breadcrumbs_data = $this->getDataset($this->object->getDataset())) {

                $this->addAppBreadcrumb($breadcrumbs_data['app_id']);

                if ($this->addDatasetBreadcrumb)
                    $this->addBreadcrumb(array(
                        'href' => '/dane/' . $breadcrumbs_data['dataset_id'],
                        'label' => $breadcrumbs_data['dataset_name']['label'],
                    ));

            }

            $selected = $this->request->params['action'];
            if ($selected == 'view')
                $selected = '';

            $this->menu['selected'] = $selected;
            $this->menu['base'] = $this->object->getUrl();
            $this->set('object_actions', $this->actions);
            $this->set('object_addons', $this->addons);

            $this->prepareMetaTags();

        }

        parent::beforeRender();

    }

    /*
    public function unsubscribe() {
	    	    
	    $this->Dataobject->unsubscribe($this->request->params['controller'], $this->request->params['id']);
	    $this->redirect($this->referer());
	    
    }
    */

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        if ($desc = $this->object->getDescription())
            $this->setMeta('description', $desc);
        $this->setMeta(array(
            'og:title' => $this->object->getTitle(),
            'og:image' => FULL_BASE_URL . '/dane/img/social/dane.jpg'
        ));
    }

}