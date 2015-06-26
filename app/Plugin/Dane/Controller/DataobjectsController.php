<?

class DataobjectsController extends AppController
{

    public $uses = array('Dane.Dataobject', 'Dane.Subscription', 'Dane.ObjectUsersManagement');
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
    
    public $objectModerable = false;

    public $_layout = array(
        'header' => array(
            'element' => 'dataobject',
        ),
        'body' => array(
            'theme' => 'default'
        ),
        'footer' => array(
	        'element' => 'default',
        ),
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
			
			if( @$this->request->params['ext'] == 'json' ) {
				$layers = isset($this->request->query['layers']) ? $this->request->query['layers'] : $this->initLayers;
			} else {
	            $layers = $this->initLayers;
            }

            if ($this->observeOptions)
                $layers[] = 'channels';
                
            if ($this->objectModerable)
                $layers[] = 'page';

            if ($this->object = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => $dataset,
                    'id' => $id,
                ),
                'layers' => $layers,
                'aggs' => $this->initAggs,
            ))
            ) {
				
				$this->object_aggs = $this->Dataobject->getAggs();
                $this->set('object_aggs', $this->object_aggs);
								
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

				if( @$this->request->params['ext'] == 'json' ) {
					
					$this->set('data', $this->object->getData());
					$this->set('layers', $this->object->getLayers());
	                $this->set('_serialize', array('data', 'layers'));
					
				} else {
					
	                $this->set('object', $this->object);
	                $this->set('objectOptions', $this->objectOptions);
	                $this->set('microdata', $this->microdata);
	                $this->set('title_for_layout', $this->object->getTitle());
                
                }

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
                        
            if( $page = $this->object->getLayer('page') ) {
								
				if( @isset($this->request->query['page']['cover']) )
					$page['cover'] = $this->request->query['page']['cover'];
					
				if( @isset($this->request->query['page']['logo']) )
					$page['logo'] = $this->request->query['page']['logo'];
					
				if( @isset($this->request->query['page']['moderated']) )
					$page['moderated'] = $this->request->query['page']['moderated'];
					
				$this->object->layers['page'] = $page;
												
				if( $page['cover'] || $page['logo'] )
					$this->_layout['header']['element'] = 'dataobject-cover';
								
				$this->set('object', $this->object);
									
			}

            $selected = $this->request->params['action'];
            if ($selected == 'view')
                $selected = '';
						
			$object_moderable = $this->objectModerable && 
			(
				in_array('2', $this->getUserRoles()) || // check if superuser 
				( $this->getPageRoles()=='1' ) // check if user has permissions to page 
			);
			
			$object_editable = $this->objectModerable && 
			(
				in_array('2', $this->getUserRoles()) || // check if superuser 
				$this->getPageRoles() // check if user has permissions to page 
			);
			
			// debug($this->getUserRoles()); die();
						
            $this->menu['selected'] = $selected;
            $this->menu['base'] = $this->object->getUrl();
            $this->set('object_actions', $this->actions);
            $this->set('object_addons', $this->addons);
            $this->set('object_moderable', $object_moderable);
            $this->set('object_editable', $object_editable);

            $this->prepareMetaTags();
        }

        parent::beforeRender();

    }

    public function getPageRoles()
    {

        if (
            $this->Auth->user() &&
            isset($this->object) &&
            ($page = $this->object->getLayer('page')) &&
            isset($page['roles'])
        ) {

            return @$page['roles']['ObjectUser']['role'];

        } else return false;

    }
    
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
    
    public function getPageRoles() {
	    
	    if( 
	    	$this->Auth->user() && 
	    	isset( $this->object ) && 
	    	( $page = $this->object->getLayer('page') ) && 
	    	isset( $page['roles'] )
	    ) {
		    
		    return @$page['roles']['ObjectUser']['role'];
		    
	    } else return false;
	    
    }

}