<?

class DataobjectsController extends AppController
{

    public $uses = array(
        'Dane.Dataobject',
        'Dane.Subscription',
        'Dane.ObjectUsersManagement',
        'Collections.Collection',
        'Pisma.Pismo',
        'Start.LetterResponse',
    );

    public $components = array('RequestHandler');

    public $object = false;
    public $initLayers = array();
    public $forceLayers = false;
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
    public $editables = array();

    /**
     * @desc Czy mogę w tym obiekcie dodawać działania?
     * @var bool
     */
    public $objectActivities = false;

    /**
     * @desc Czy mogę w tym obiekcie edytować dane?
     * @var bool
     */
    public $objectData = false;

    /**
     * @desc Czy mogę obserwować obiekt?
     * @var bool
     */
    public $observeOptions = false;

    /**
     * @desc Czy mogę dodawać obiekt do kolekcji?
     * @var bool
     */
    public $collectionsOptions = true;

    /**
     * @desc Czy wyświetlać kolekcje obiektu?
     * @var bool
     */
    public $objectCollections = false;

    /**
     * @desc Czy wyświetlać publiczne pisma obiektu?
     * @var bool
     */
    public $objectLetters = false;


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

    public function dane()
    {
        if(!$this->objectData)
            throw new NotFoundException;

        $this->addInitLayers('page');

        if(@$this->request->params['controller'] == 'krs_podmioty') {
            $this->addInitLayers('bank_account');
            $this->addInitLayers('tags');
        }

        $this->_prepareView();
        if(!$this->_canEdit())
            throw new ForbiddenException;

        $this->render('Dane.KrsPodmioty/dane');
    }

    public function addInitLayers($layers)
    {

        if (is_array($layers)) {
            $this->initLayers = array_merge($this->initLayers, $layers);
        } else {
            $this->initLayers[] = $layers;
        }

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
				
        // debug(array('dataset' => $dataset, 'id' => $id, 'slug' => $slug)); die();

        if (
            $dataset &&
            $id &&
            is_numeric($id)
        ) {


			if( empty($this->forceLayers) ) {

	            if (@$this->request->params['ext'] == 'json') {
	                $layers = isset($this->request->query['layers']) ? $this->request->query['layers'] : $this->initLayers;
	            } else {
	                $layers = $this->initLayers;
	            }
				
	            if ($this->observeOptions) {
	                $layers[] = 'channels';
	            }
	
	            $layers[] = 'dataset';
	            $layers[] = 'page';
            
            } else {
	            	            
	            $layers = $this->forceLayers;
	            
            }

            $this->object = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => $dataset,
                    'id' => $id,
                ),
                'layers' => $layers,
                'aggs' => $this->initAggs,
            ));
                        
            $code = (int)$this->Dataobject->getDataSource()->getLastResponseCode();

            if ($code >= 400) {
                if ($code == 400)
                    throw new BadRequestException();
                elseif ($code == 403)
                    throw new ForbiddenException();
                elseif ($code == 404) {
                    throw new NotFoundException();
                } elseif ($code == 405)
                    throw new MethodNotAllowedException();
                elseif ($code == 500)
                    throw new MethodNotAllowedException();
                elseif ($code == 501)
                    throw new NotImplementedException();
                else
                    throw new CakeException();
            }

            $this->object_aggs = $this->Dataobject->getAggs();
            $this->set('object_aggs', $this->object_aggs);
						
            if (
                ($this->domainMode == 'MP') && 
                (
	                !isset($this->request->params['from_slug']) || 
	                !$this->request->params['from_slug']
                ) && 
                (
                    !isset($this->request->params['ext']) ||
                    !in_array($this->request->params['ext'], array('json', 'html'))
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

            if (@$this->request->params['ext'] == 'json') {

                $this->set('data', $this->object->getData());
                $this->set('layers', $this->object->getLayers());
                $this->set('_serialize', array('data', 'layers'));

            } else {

                $this->set('object', $this->object);
                $this->set('objectOptions', $this->objectOptions);
                $this->set('microdata', $this->microdata);
                $this->set('title_for_layout', $this->object->getTitle());

            }

        } else {
            throw new BadRequestException();
        }

    }

    protected function _canEdit()
    {
        return (
            @in_array('2', $this->getUserRoles()) ||
            (
                $this->getPageRoles() &&
                in_array($this->getPageRoles(), array('1', '2'))
            )
        );
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

    public function dodaj_dzialanie()
    {
        if(!$this->objectActivities)
            throw new NotFoundException;

        $this->request->params['action'] = 'dzialania';

        $this->addInitLayers(array('dzialania_nowe'));
        $this->_prepareView();

        if(!$this->_canEdit())
            throw new ForbiddenException;

        $this->ActivitiesFile = $this->Components->load('Dane.ActivitiesFile');
        $this->ActivitiesFile->delete();
        $this->render('Dane.KrsPodmioty/dzialanie_form');
    }

    public function kolekcje() {
        if(!$this->objectCollections)
            throw new NotFoundException;

        $this->request->params['action'] = 'kolekcje';

        $this->_prepareView();
        if(isset($this->params['subid']) && is_numeric($this->params['subid'])) {
            $id = (int) $this->params['subid'];
            $item = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'kolekcje',
                        'id' => $id
                    )
                )
            );

            if(!$item)
                throw new NotFoundException;

            if($item->getData('is_public') != '1' ||
                $item->getData('object_id') != $this->object->getGlobalId())
                throw new NotFoundException;

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'collection_id' => $id,
                ),
            ));

            $this->title = $item->getTitle();
            $this->set('item', $item);
            $this->render('Dane.KrsPodmioty/kolekcja');
        } else {
            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'kolekcje',
                    'kolekcje.object_id' => $this->object->getGlobalId(),
                ),
                //'aggsPreset' => 'dzialania_admin',
                'searchTitle' => 'Szukaj w kolekcjach...',
                'objectOptions' => array(
                    'public' => true,
                    'base_url' => $this->object->getUrl()
                ),
            ));

            $this->set('title_for_layout', 'Kolekcje ' . $this->object->getData('nazwa'));
            $this->render('Dane.KrsPodmioty/kolekcje');
        }
    }

    public function pisma() {
        if(!$this->objectLetters)
            throw new NotFoundException;

        $this->request->params['action'] = 'pisma';
        $this->_prepareView();

        if(isset($this->params['subid'])) {
            $id = $this->params['subid'];
            $pismo = $this->Dataobject->find('first', array(
                    'conditions' => array(
                        'dataset' => 'pisma',
                        'id' => $id
                    )
                )
            );

            if(!$pismo->getData('is_public') || $pismo->getData('object_id') != $this->object->getGlobalId())
                throw new NotFoundException;

            $this->set('responses', $this->LetterResponse->getByLetter(
                $pismo->getData('alphaid')
            ));

            $this->set('pismo', $pismo);
            $this->render('Dane.KrsPodmioty/pismo');
        } else {
            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => array(
                    'dataset' => 'pisma',
                    'pisma.object_id' => $this->object->getGlobalId(),
                ),
                'searchTitle' => 'Szukaj w pismach...',
                'browserTitle' => 'Pisma:',
                'objectOptions' => array(
                    'public' => true,
                    'base_url' => $this->object->getUrl()
                ),
            ));

            $this->set('title_for_layout', 'Pisma ' . $this->object->getData('nazwa'));
            $this->render('Dane.KrsPodmioty/pisma');
        }
    }

    public function pismo($id) {
        if(!$this->objectLetters)
            throw new NotFoundException;

        $this->request->params['action'] = 'pisma';

    }

    public function dzialania()
    {
        if(!$this->objectActivities)
            throw new NotFoundException;

        $this->_prepareView();
        if($id = @$this->request->params['subid']) {

            $dzialanie = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'dzialania',
                    'id' => $id
                ),
                'layers' => array(
                    'features'
                ),
                'aggs' => array(
                    'tags' => array(
                        'nested' => array(
                            'path' => 'tags',
                        ),
                        'aggs' => array(
                            'id' => array(
                                'terms' => array(
                                    'field' => 'tags.id',
                                ),
                                'aggs' => array(
                                    'label' => array(
                                        'terms' => array(
                                            'field' => 'tags.label',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ));

            $aggs = $this->Dataobject->getAggs();
            $tags = array();

            if( @isset( $aggs['tags']['id']['buckets'] ) ) {
                foreach( $aggs['tags']['id']['buckets'] as $b ) {
                    if(
                        ( $id = @$b['key'] ) &&
                        ( $label = @$b['label']['buckets'][0]['key'] )
                    ) {

                        $tags[] = array(
                            'id' => $id,
                            'label' => $label,
                        );

                    }
                }
            }

            $this->set('dzialanie_tags', $tags);

            if (!$dzialanie)
                throw new NotFoundException;


            if($features = $dzialanie->getLayer('features')) {
                $this->loadModel('Sejmometr.Sejmometr');
                if($mailing = @$features['mailings'][0]) {
                    if($mailing['target'] == '0') {

                        $okregi = Cache::read('Sejmometr.okregi_sejm', 'long');
                        if (!$okregi) {
                            $okregi = $this->Sejmometr->okregi_sejm();
                            Cache::write('Sejmometr.okregi_sejm', $okregi, 'long');
                        }

                        $this->set('okregi', $okregi);

                    } else {

                        $okregi = Cache::read('Sejmometr.okregi_senat', 'long');
                        if (!$okregi) {
                            $okregi = $this->Sejmometr->okregi_senat();
                            Cache::write('Sejmometr.okregi_senat', $okregi, 'long');
                        }

                        $this->set('okregi', $okregi);

                    }
                }
            }

            $this->set('dzialanie', $dzialanie);

            $this->loadModel('Dane.ActivitiesFiles');
            $this->set('files', $this->ActivitiesFiles->getByActivity($dzialanie->getId()));

            if(@$this->request->params['subaction'] == 'edytuj') {

                if($this->_canEdit()) {

                    if($data = @file_get_contents($dzialanie->getThumbnailUrl('1'))) {
                        $this->set('dzialanie_photo_base64', 'data:image/jpeg;base64,' . base64_encode($data));
                    }

                    $this->render('Dane.KrsPodmioty/dzialanie_form');
                }
                else
                {
                    if(!$this->Auth->user())
                        throw new UnauthorizedException;
                    else
                        throw new ForbiddenException;
                }

            } else {
                $this->render('Dane.KrsPodmioty/dzialanie');
            }

        } else {

            $conditions = array(
                'dataset' => 'dzialania',
                'dzialania.dataset' => $this->object->getDataset(),
                'dzialania.object_id' => $this->object->getId(),
            );

            if(!$this->_canEdit()) {
                $conditions['dzialania.status'] = '1';
            }

            $this->Components->load('Dane.DataBrowser', array(
                'conditions' => $conditions,
                'aggsPreset' => 'dzialania_admin',
                'searchTitle' => 'Szukaj w działaniach...',
                'browserTitle' => 'Działania:',
                'browserTitleElement' => 'Dane.dodaj_dzialanie',
            ));

            $this->set('title_for_layout', 'Działania ' . $this->object->getData('nazwa'));
            $this->render('Dane.KrsPodmioty/dzialania');
        }
    }

    public function zalacznik() {
        if(!$this->objectActivities)
            throw new NotFoundException;

        if(isset($this->request->params['subid']) && isset($this->request->params['subslug'])) {
            $this->loadModel('Dane.ActivitiesFiles');
            $this->redirect(
                $this->ActivitiesFiles->getFile(
                    (int) $this->request->params['subid'],
                    (int) $this->request->params['subslug']
                )
            );
        } else throw new NotFoundException;
    }

	public function addObjectEditable($e)
	{
		if( is_string($e) )
			$this->editables[] = $e;
		elseif( is_array($e) )
			$this->editables = array_merge($this->editables, $e);
	}

    public function addInitAggs($aggs = array())
    {
	    if($aggs)
	        $this->initAggs = array_merge($this->initAggs, $aggs);
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

        if (!$is_json && $this->object) {

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

            } elseif( $dataset = $this->object->getLayer('dataset') ) {
				
				$this->addAppBreadcrumb('dane');
				
	            $this->addBreadcrumb(array(
                    'href' => '/dane/' . $dataset['Dataset']['alias'],
                    'label' => $dataset['Dataset']['name'],
                ));

            }


            if(
	            !(
	            	( $this->object->getDataset()=='gminy') &&
	            	( $this->object->getId()=='903')
	            ) &&
            	( $page = $this->object->getLayer('page') )
            ) {

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


			$object_editable = array();

			if(
				@in_array('2', $this->getUserRoles()) || // check if superuser
				( $this->getPageRoles()=='1' ) // check if user has permissions to page
			) {

				$object_editable[] = 'users';
			}

			if(
				@in_array('2', $this->getUserRoles()) || // check if superuser
				$this->getPageRoles() // check if user has permissions to page
			) {

				$object_editable[] = 'cover';
				$object_editable[] = 'logo';

			}

			if( !empty($this->editables) )
				$object_editable = array_merge($object_editable, $this->editables);

            $this->menu['selected'] = $selected;
            $this->menu['base'] = $this->object->getUrl();
            $this->set('object_actions', $this->actions);
            $this->set('object_addons', $this->addons);
            $this->set('object_editable', $object_editable);
            $this->set('_canEdit', $this->_canEdit());
            $this->set('_collectionsOptions', $this->collectionsOptions);
            $this->set('_manageOptions', (boolean) count($object_editable));
            $this->set('_manageOptionsModals', $object_editable); // alias
            
            $this->set('app_chapters', array(
	            'items' => array(),
            ));
            
            $this->prepareMetaTags();
        }

        parent::beforeRender();

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

    public function post()
    {

	    $response = false;

	    if(
	    	@$this->request->params['pass'][0] &&
	    	@$this->request->params['pass'][1]
	    ) {

            if(in_array($this->request->params['pass'][0], array(
                'krs_podmioty', 'gminy'
            ))) {

                if(in_array($this->request->data['_action'], array(
                    'edit_activity',
                    'add_activity'
                ))) {

                    $this->_prepareView();
                    $this->request->data['owner_name'] = $this->object->getTitle();

                    $this->ActivitiesFile = $this->Components->load('Dane.ActivitiesFile');
                    $this->request->data['files'] = $this->ActivitiesFile->getFiles();
                    $this->ActivitiesFile->clear();
                }
            }
			
			if( 
				( $this->request->data['_action']=='pobierz_nowy_odpis' ) && 
				!$this->Auth->user()
			) {
				$this->redirect( $this->referer() );
				exit();
			}
						
		    $response = $this->Dataobject->getDatasource()->request('dane/' . $this->request->params['pass'][0] . '/' . $this->request->params['pass'][1], array(
			    'method' => 'POST',
			    'data' => $this->request->data,
		    ));

        }

        $this->set('response', $response);
        $this->set('_serialize', array('response'));

        if(!$this->request->is('ajax')) {
            if(isset($response['flash_message'])) {
                $this->Session->setFlash($response['flash_message'], 'default', array(
                    'close' => true
                ));
            }

            $this->redirect(
                isset($response['redirect_url']) ?
                    $response['redirect_url'] : $this->referer()
            );
        }

    }

    public function uploadActivityFile() {
        if(!$this->objectActivities || !isset($this->request->params['form']['file']))
            throw new NotFoundException;

        if(!$this->_canEdit())
            throw new ForbiddenException;

        $this->ActivitiesFile = $this->Components->load('Dane.ActivitiesFile');

        $response = $this->ActivitiesFile->save(
            $this->request->params['form']['file']
        );

        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }

}
