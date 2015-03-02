<?

class DataobjectsBrowserComponent extends Component
{

    public $settings = array();
    public $source = array();
    public $title = false;
    public $noResultsTitle = false;
    public $href = false;
    public $mode = false;
    public $tag = false;
    public $datasetLocked = false;
    public $showTitle = false;
    public $titleTag = 'h2';
    public $hlFields = false;
    public $hlFieldsPush = false;
    public $routes = array();
    public $inline = false;
    public $limit = 20;
    public $conditions = array();
    public $orders = array();
    public $allowedParams = false;

    public $dataset = false;
    public $datachannel = false;
    public $dataset_dictionary = array();
    public $renderFile = false;
    public $class = false;
    public $back = false;
    public $backTitle = false;

    public $excludeFilters = array();
    public $hiddenFilters = array();

    public $components = array(
        'Paginator',
        'RequestsHandler'
    );

    public $helpers = array(
        'Number',
        'Dane.Filter',
        'Dane.Dataobject',
    );

    public $config = array(
        'controlls' => array('sortings'),
        'defaults' => array(
            'details' => false,
        ),
    );

    public function __construct($collection, $settings = array())
    {

        parent::__construct($collection, $settings);

        $this->settings = $settings;

        if (isset($settings['title'])) {
            $this->showTitle = true;
            $this->title = $settings['title'];
        }

        if (isset($settings['href']) && $settings['href']) {
            $this->href = $settings['href'];
        }

        if (isset($settings['dataset_dictionary']) && $settings['dataset_dictionary'] && is_array($settings['dataset_dictionary'])) {
            $this->dataset_dictionary = $settings['dataset_dictionary'];
        }

        if (isset($settings['titleTag']) && $settings['titleTag']) {
            $this->titleTag = $settings['titleTag'];
        }

        if (isset($settings['noResultsTitle']) && $settings['noResultsTitle']) {
            $this->noResultsTitle = $settings['noResultsTitle'];
        }

        if (isset($settings['excludeFilters'])) {
            $this->excludeFilters = $settings['excludeFilters'];
        }

        if (isset($settings['hiddenFilters'])) {
            $this->hiddenFilters = $settings['hiddenFilters'];
        }

        if (isset($settings['hlFields'])) {
            $this->hlFields = $settings['hlFields'];
        }

        if (isset($settings['hlFieldsPush'])) {
            $this->hlFieldsPush = $settings['hlFieldsPush'];
        }

        if (isset($settings['routes'])) {
            $this->routes = $settings['routes'];
        }

        if (isset($settings['class'])) {
            $this->class = $settings['class'];
        }

        if (isset($settings['renderFile'])) {
            $this->renderFile = $settings['renderFile'];
        }

        if (isset($settings['limit'])) {
            $this->limit = max(min($settings['limit'], 1000), 0);
        }

        if (isset($settings['conditions'])) {
            $this->conditions = $settings['conditions'];
        }

        if (isset($settings['allowedParams']) && $settings['allowedParams']) {
            $this->allowedParams = $settings['allowedParams'];
        }

        if (isset($settings['back']) && $settings['back']) {
            $this->back = $settings['back'];
        }

        if (isset($settings['backTitle']) && $settings['backTitle']) {
            $this->backTitle = $settings['backTitle'];
        }

				
        $add_source_params = array();
        $source_params = array();

        if (isset($settings['source'])) {
            $source_parts = explode(' ', $settings['source']);
            foreach ($source_parts as $part) {

                $p = strpos($part, ':');
                if ($p !== false) {
                    $key = substr($part, 0, $p);
                    $value = substr($part, $p + 1);

                    $source_params[$key] = $value;

                    if (($key != 'dataset') && ($key != 'datachannel')) {
                        $add_source_params[$key] = $value;
                    }
                }

            }
        }

        $this->source = $add_source_params;


        if (isset($settings['dataset'])) {
            $source_params['dataset'] = $settings['dataset'];
        }


        if (isset($source_params['dataset']) && !empty($source_params['dataset'])) {
            $this->mode = 'dataset';
            $this->tag = $source_params['dataset'];
            $this->datasetLocked = true;
        } elseif (isset($source_params['datachannel']) && !empty($source_params['datachannel'])) {
            $this->mode = 'datachannel';
            $this->tag = $source_params['datachannel'];
        } else {
            $this->mode = '*';
        }

    }

    public function beforeRender(Controller $controller)
    {

        $q = '';
        $conditions = $this->conditions;
        $order = array();
        $order_selected = false;
        $useDefaults = true;

        $filters = array();
        $switchers = array();
        $orders = array();

        $controller->mode = 'dataobjectsBrowser';


        if (
            isset($controller->request->query['dataset']) &&
            !empty($controller->request->query['dataset'])
        ) {

            $dataset = is_array($controller->request->query['dataset']) ?
                $controller->request->query['dataset'][0] :
                $controller->request->query['dataset'];

            if ($dataset) {

                if ($this->mode == 'datachannel') {

                    $url = '/dane/' . $dataset;
                    if (isset($controller->request->query['q']) && $controller->request->query['q']) {
                        $url .= '?q=' . urlencode($controller->request->query['q']);
                    }

                    $controller->redirect($url);
                    exit();
                }


                $this->mode = 'dataset';
                $this->tag = $dataset;

            }
        }


        if (!$this->href) {
            $here = $controller->here;

            if ($p = strpos($here, '.')) {
                $here = substr($here, 0, $p);
            }

            /*
            $strlen = strlen($here);
            if( $here[ $strlen-1 ]=='/' )
                $here = substr($here, 0, $strlen-1);
            */

            $this->href = $here;
        }

        if ($this->mode == 'dataset') {
            $this->read_dataset_config($this->tag);
        }


        if (!empty($this->source)) {

            $source_parts = array();
            foreach ($this->source as $key => $value) {
                $source_parts[] = $key . ':' . $value;
            }

            $conditions['_source'] = implode(' ', $source_parts);

        }

        if (!isset($controller->request->query['order']) && isset($this->settings['order'])) {
            $controller->request->query['order'] = $this->settings['order'];
        }

        $query_keys = array_keys($controller->request->query);

        foreach ($query_keys as $key) {

            $value = $controller->request->query[$key];
            switch ($key) {

                case 'order': {
                    $order_parts = explode(' ', $value);
                    $order = array(
                        'field' => $order_parts[0],
                        'direction' => isset($order_parts[1]) ? $order_parts[1] : 'desc',
                    );
                    $order['str'] = $order['field'] . ' ' . $order['direction'];

                    $this->hlFieldsPush = array($order['field']);

                    break;
                }

                case 'q': {
                    $q = $value;
                    if ($value) {
                        $orders[] = array(
                            'sorting' => array(
                                'field' => 'score',
                                'label' => 'Trafność',
                                'direction' => 'desc',
                            ),
                        );
                    }
                    break;
                }

                case 'search': {

                    $useDefaults = false;
                    break;

                }

                case 'submit': {

                    break;

                }

                default: {

                    $key = str_replace(':', '.', $key);

                    if (in_array($key, $this->excludeFilters)) {
                        continue;
                    }

                    if (array_key_exists($key, $conditions)
                        && ($conditions[$key] != $value)
                    ) {
                        $conditions[$key][] = $value;
                    } else {
                        $conditions[$key] = $value;
                    }


                }

            }
        }

        if ($this->mode == 'dataset') {

            $conditions['dataset'] = $this->tag;


            $dataset = $controller->API->getDataset($this->tag, array(
                'full' => true,
            ));

            if ($dataset) {

                $this->dataset = $dataset;

                foreach ($this->excludeFilters as &$ef)
                    if (strpos($ef, '.') === false)
                        $ef = $this->tag . '.' . $ef;


                if (!$this->title) {
                    $this->title = $dataset['Dataset']['name'];
                }

                // ŁADOWANIE SORTOWAŃ

                $orders = array_merge($orders, $dataset['orders']);

                if (isset($order['field'])) {
                    foreach ($orders as &$_order) {
                        if ($_order['sorting']['field'] == $order['field']) {
                            $this->hlFieldsPush = $order['field'];
                            $_order['selected_direction'] = $order['direction'];
                            $order_selected = true;
                            break;
                        }
                    }
                }


                // ŁADOWANIE PRZEŁĄCZNIKÓW
                $switchers = $dataset['switchers'];
                if ($useDefaults && !empty($switchers)) {
                    foreach ($switchers as $switcher) {

                        $switcher = $switcher['switcher'];
                        if ($switcher['dataset_search_default'] == '1') {
                            $conditions['!' . $switcher['name']] = '1';
                        }

                    }
                }


                // ŁADOWANIE FILTRÓW
                $filters = $dataset['filters'];

                if (!empty($filters)) {

                    $_filters = array();
                    foreach ($filters as $filter) {
                        if (!in_array($filter['filter']['field'], $this->excludeFilters)) {
                            $_filters[] = $filter;
                        }
                    }

                    $filters = $_filters;

                }

            }

        } elseif ($this->mode == 'datachannel') {


            $datachannel = $controller->API->getDatachannel($this->tag, array(
                'full' => true,
            ));

            $this->datachannel = $datachannel;
            $datachannel = $datachannel['Datachannel'];
            $this->title = $datachannel['name'];

            // $data = $controller->API->getDatachannel($this->tag);
            // $datachannel = $data['Datachannel'];
            $conditions['datachannel'] = $datachannel['slug'];

            $title_for_layout = $datachannel['name'];


            $filters[] = array(
                'filter' => array(
                    'field' => 'dataset',
                    'typ_id' => '2',
                    'parent_field' => false,
                    'label' => 'Zbiory danych:',
                    'desc' => false,
                    'multi' => '0',
                ),
            );

            $orders[] = array(
                'sorting' => array(
                    'field' => 'date',
                    'label' => 'Data',
                    'direction' => 'desc',
                ),
            );


        } else {


            $filters[] = array(
                'filter' => array(
                    'field' => 'dataset',
                    'typ_id' => '5',
                    'parent_field' => false,
                    'label' => 'Zbiory danych:',
                    'desc' => false,
                    'multi' => '0',
                    'dictionary' => $this->dataset_dictionary,
                ),
            );


        }


        // ŁADOWANIE OBIEKTÓW
        // $controller->Dataobject = ClassRegistry::init('Dane.Dataobject');
        $controller->loadModel('Dane.Dataobject');


        $queryData = array(
            'q' => $q,
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'facets' => true,
            'limit' => $this->limit,
        );
        
        
        // debug( $queryData );


        if (empty($order) && !empty($orders)) {
            $order = array(
                'field' => $orders[0]['sorting']['field'],
                'direction' => $orders[0]['sorting']['direction'],
                'str' => $orders[0]['sorting']['field'] . ' ' . $orders[0]['sorting']['direction'],
            );
        }


        if (!$order_selected && !empty($order)) {
            foreach ($orders as &$o) {
                if ($o['sorting']['field'] == $order['field']) {
                    $this->hlFieldsPush = $order['field'];
                    $o['selected_direction'] = $order['direction'];
                }
            }
        }


        if (!empty($order)) {
            $queryData['order'] = $order['str'];
        }


        $this->Paginator->settings = $queryData;
        $objects = $this->Paginator->paginate('Dataobject');


        $pagination = $controller->Dataobject->pagination;
        $pagination['page'] = (int)@$controller->request->query['page'];
        if (!$pagination['page']) {
            $pagination['page'] = 1;
        }


        $facets = $controller->Dataobject->facets;
        $didyoumean = $controller->Dataobject->didyoumean;

        $total = $controller->Dataobject->total;

        if (isset($controller->request->query)) {
            $controller->data = array('Dataset' => $controller->request->query);
        }

        if (empty($this->excludeFilters)) {

            $emptyFilters = empty($filters) && empty($switchers);

        } else {

            $_filters = array();
            foreach ($filters as $f)
                if (!in_array($f['filter']['field'], $this->excludeFilters))
                    $_filters[] = $f;

            $emptyFilters = empty($_filters) && empty($switchers);

        }


        $page = array(
            'title' => $this->title,
            'href' => $this->href,
            'mode' => $this->mode,
            'tag' => $this->tag,
            'datasetLocked' => $this->datasetLocked,
            'showTitle' => $this->showTitle,
            'titleTag' => $this->titleTag,
            'noResultsTitle' => $this->noResultsTitle,
            'back' => $this->back,
            'backTitle' => $this->backTitle,
        );

        $config = $this->config;


        if (@$controller->request->params['ext'] == 'json') {


            $view = new View($controller, false);

            $objects = $view->element('Dane.DataobjectsBrowser/objects', array_merge(
                compact('objects', 'page', 'defaults', 'emptyFilters'),
                array(
                    'dataBrowser' => $this,
                    'defaults' => $config['defaults'],
                    'renderFile' => $this->renderFile,
                    'class' => $this->class,
                )
            ));

            $header = $view->element('Dane.DataobjectsBrowser/header', array_merge(
                compact('pagination', 'orders', 'page', 'didyoumean', 'emptyFilters'),
                array(
                    'controlls' => $config['controlls'],
                )
            ));


            $filters = $view->element('Dane.DataobjectsBrowser/filters', array_merge(compact('conditions', 'filters', 'switchers', 'facets', 'page', 'emptyFilters'), array('dataBrowser' => $this)));
            $pagination = $view->element('Dane.DataobjectsBrowser/pagination', compact('pagination'));

            $controller->set(compact('objects', 'header', 'filters', 'pagination'));
            $controller->set('_serialize', array('objects', 'header', 'filters', 'pagination'));


        } else {


            $path = App::path('View', 'Dane');
            $path = $path[0] . $controller->viewPath . '/' . $controller->view . '.ctp';
            $controller->view = $this->getViewPath();

            if (file_exists($path)) {
                $controller->set('originalViewPath', $path);
            }

            $controller->set(array_merge(
                compact('conditions', 'objects', 'pagination', 'orders', 'filters', 'didyoumean', 'total', 'facets', 'page', 'title_for_layout', 'switchers', 'q', 'emptyFilters'),
                array(
                    'renderFile' => $this->renderFile,
                    'class' => $this->class,
                    'dataBrowser' => $this,
                )
            ));


        }


    }

    private function read_dataset_config($dataset)
    {

        $file = APP . 'Config/DataobjectsBrowser/datasets/' . $dataset . '.json';
        if (
            file_exists($file) &&
            ($config = json_decode(file_get_contents($file), true))
        ) {
            $this->config = array_merge($this->config, $config);
        }

        return $this->config;

    }

    public function getViewPath()
    {

        $path = App::path('View', 'Dane');

        return $path[0] . '/Component/dataobjectsBrowser/view.ctp';

    }

}