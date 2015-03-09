<?

App::uses('HttpSocket', 'Network/Http');

class mpAPISource extends DataSource {

/**
 * An optional description of your datasource
 */
    public $description = '_mojePaństwo REST API';

/**
 * Our default config options. These options will be customized in our
 * ``app/Config/database.php`` and will be merged in the ``__construct()``.
 */
    public $config = array(
        'apiKey' => '',
        'host' => 'http://mojepanstwo.pl:4444',
        'verbose' => false,
    );
    
/**
 * If we want to create() or update() we need to specify the fields
 * available. We use the same array keys as we do with CakeSchema, eg.
 * fixtures and schema migrations.
 */
    protected $_schema = array(
 /*
        'id' => array(
            'type' => 'integer',
            'null' => false,
            'key' => 'primary',
            'length' => 11,
        ),
        'name' => array(
            'type' => 'string',
            'null' => true,
            'length' => 255,
        ),
        'message' => array(
            'type' => 'text',
            'null' => true,
        ),
*/ 
    );

/**
 * Create our HttpSocket and handle any config tweaks.
 */
    public function __construct($config) {
        parent::__construct($config);
        $this->Http = new HttpSocket();
		$this->Http->configAuth('Basic', 'macysz', '');
    }

/**
 * Since datasources normally connect to a database there are a few things
 * we must change to get them to work without a database.
 */

/**
 * listSources() is for caching. You'll likely want to implement caching in
 * your own way with a custom datasource. So just ``return null``.
 */
    public function listSources($data = null) {
        return null;
    }

/**
 * describe() tells the model your schema for ``Model::save()``.
 *
 * You may want a different schema for each model but still use a single
 * datasource. If this is your case then set a ``schema`` property on your
 * models and simply return ``$model->schema`` here instead.
 */
    public function describe($model) {
        return $this->_schema;
    }

/**
 * calculate() is for determining how we will count the records and is
 * required to get ``update()`` and ``delete()`` to work.
 *
 * We don't count the records here but return a string to be passed to
 * ``read()`` which will do the actual counting. The easiest way is to just
 * return the string 'COUNT' and check for it in ``read()`` where
 * ``$data['fields'] === 'COUNT'``.
 */
    public function calculate(Model $model, $func, $params = array()) {
        return 'COUNT';
    }

/**
 * Implement the R in CRUD. Calls to ``Model::find()`` arrive here.
 */
    public function read(Model $model, $queryData = array(),
        $recursive = null) {
        /**
         * Here we do the actual count as instructed by our calculate()
         * method above. We could either check the remote source or some
         * other way to get the record count. Here we'll simply return 1 so
         * ``update()`` and ``delete()`` will assume the record exists.
         */
        if ($queryData['fields'] === 'COUNT') {
            return array(array(array('count' => 1)));
        }
        /**
         * Now we get, decode and return the remote data.
         */
        $queryData['conditions']['apiKey'] = $this->config['apiKey'];
        $json = $this->Http->get(
            'http://example.com/api/list.json',
            $queryData['conditions']
        );
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return array($model->alias => $res);
    }

/**
 * Implement the C in CRUD. Calls to ``Model::save()`` without $model->id
 * set arrive here.
 */
    public function create(Model $model, $fields = null, $values = null) {
        $data = array_combine($fields, $values);
        $data['apiKey'] = $this->config['apiKey'];
        $json = $this->Http->post('http://example.com/api/set.json', $data);
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return true;
    }

/**
 * Implement the U in CRUD. Calls to ``Model::save()`` with $Model->id
 * set arrive here. Depending on the remote source you can just call
 * ``$this->create()``.
 */
    public function update(Model $model, $fields = null, $values = null,
        $conditions = null) {
        return $this->create($model, $fields, $values);
    }

/**
 * Implement the D in CRUD. Calls to ``Model::delete()`` arrive here.
 */
    public function delete(Model $model, $id = null) {
        $json = $this->Http->get('http://example.com/api/remove.json', array(
            'id' => $id[$model->alias . '.id'],
            'apiKey' => $this->config['apiKey'],
        ));
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return true;
    }
    
    private function getPath($endpoint) {
	    return $this->config['host'] . '/' . $endpoint;
    }
        
    private $allowed_methods = array(
	    'GET', 'POST', 'DELETE', 'PATCH'
    );
    
    public function request($endpoint, $params = array()) {
	    
	    $path = $this->getPath($endpoint);
	    $method = ( isset($params['method']) && in_array($params['method'], $this->allowed_methods) ) ? $params['method'] : 'GET';
	    $data = isset($params['data']) ? $params['data'] : false;
	    $request = isset($params['request']) ? $params['request'] : array();
	   
	    if( isset($params['user_id']) )
	    	$request['header']['X_USER_ID'] = $params['user_id'];
	    	
	    switch( $method ) {
		    case 'GET': { $json = $this->Http->get($path, $data, $request); break; }
		    case 'POST': { $json = $this->Http->post($path, $data, $request); break; }
		    case 'DELETE': { $json = $this->Http->delete($path, $data, $request); break; }
		    case 'PATCH': { $json = $this->Http->patch($path, $data, $request); break; }
	    }
	    	    
	    $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return $res;
	    
    }

}