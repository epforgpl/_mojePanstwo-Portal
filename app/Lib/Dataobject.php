<?

namespace MP\Lib;

class Dataobject
{
    public $force_hl_fields = false;
    public $data;
    public $static;
    public $layers = array();
    public $contexts = array();
    public $id;
    public $dataset;
    public $object_id;
    public $global_id;
    public $slug;
    public $hl = null;
    public $classes = array();
    public $subscribtions = false;
    public $inner_hits = array();
    public $subscriptions = array();
    public $options = array();
    public $page = array();
    public $_pageDescription = true;
    public $collection = array();
    protected $schema = array();
    protected $_routes = array(
        'date' => 'data',
        'title' => 'title',
        'shortTitle' => 'title',
        'description' => 'opis',
        'label' => 'label',
        'titleAddon' => false,
        'position' => false,
    );
    protected $routes = array();
    protected $fields = array();
    protected $hl_fields = array();
    protected $tiny_label = '';

    public function __construct($params = array(), $options = array())
    {
		
		$this->options = $options;
		
		foreach( $params as $key => $value ) {
			
			if( $key == 'id' ) {
				$this->id = $value;
			
			} elseif( $key == 'global_id' ) {
				$this->object_id = $this->global_id = $value;
				
			} elseif( $key == 'dataset' ) {
				$this->dataset = $value;
			
			} elseif( $key == 'slug' ) {
				$this->slug = $value;
				
			} elseif( $key == 'data' ) {
				$this->data = $value;
			
			} elseif( $key == 'layers' ) {
				$this->layers = $value;			
				
			} elseif( $key == 'static' ) {
				$this->static = $value;
			
			} elseif( $key == 'score' ) {
				$this->layers['score'] = $value;
				
			} elseif( $key == 'highlight' ) {
				
				if( isset($value[0]) )
					$this->layers['highlight'] = $value[0];
					
			} elseif( $key == 'contexts' ) {
				$this->contexts = $value;
				
			} elseif( $key == 'subscribtion' ) {
				$this->subscribtion = $value;
				
			} elseif( $key == 'subscribtions' ) {
				$this->subscribtions = $value;
				
			} elseif( $key == 'inner_hits' ) {
				$this->inner_hits = $value;
				
			} elseif( $key == 'collection' ) {
				$this->collection = $value;
				
			} elseif( $key == 'Aggs' ) {

				if( @$value['_page']['page']['hits']['hits'][0]['_source']['data'] )
					$this->page = $value['_page']['page']['hits']['hits'][0]['_source']['data'];
				
			} else {
				
				$this->fields[ $key ] = $value;
				
			}
		}
		
		
        $temp = array();
        if( !empty($this->data) ) {
	        foreach( $this->data as $key => $val ) {

	        	$p = strpos($key, $this->dataset.'.');

	        	if( $p===0 )
	        		$temp[] = substr($key, strlen($this->dataset)+1);

	        }
        }
				
        foreach( $temp as $t )
        	$this->data[ $t ] = $this->data[ $this->dataset . '.' . $t ];

        $this->routes = array_merge($this->_routes, $this->routes);

    }
	
	public function getField( $field = false ) {
		
		if(
			$field && 
			array_key_exists($field, $this->fields)
		)
			return $this->fields[ $field ];
		else
			return null;
		
	}
	
	public function getPageThumbnailUrl() {
		return false;
	}
	
	public function getSubscribtion() {
		return (boolean) $this->subscribtion;
	}

	public function getMetaDescription($preset = false) {

		$parts = $this->getMetaDescriptionParts($preset);

		if( empty($parts) )
			return false;
		else {
			$parts = array_filter($parts);
			return implode(' <span class="sep">&mdash;</span> ', $parts);
		}

	}

    public function getMetaDescriptionParts($preset = false)
    {
        return false;
    }

	public function getMataDate() {
		return false;
	}

	public function getClasses() {
		$output = $this->classes;
		$output[] = 'objclass';
		if( $this->getDataset() )
			$output[] = $this->getDataset();
		return $output;
	}

    public function getDataset()
    {
        return @$this->dataset;
    }

	public function getLayers()
	{
		return $this->layers;
	}

    public function getScore()
    {
        if ($score = $this->getLayer('score'))
            return (float)@$score['value'];
        return 0;
    }

    public function getLayer($layer)
    {
        return array_key_exists($layer, $this->layers) ? $this->layers[$layer] : false;
    }

    public function getPage($field = '*') {
        return $field == '*' ? $this->page : @$this->page[$field];
    }

    public function getStatic($field = '*')
    {
	    if( isset($this->static) && !empty($this->static) )
	        return $field == '*' ? $this->static : @$this->static[$field];
	    else
	    	return false;
    }

    public function getGlobalId()
    {
        return $this->global_id;
    }

    public function getDate()
    {
        return @substr($this->getData($this->routes['date']), 0, 10);
    }

    public function getData($field = '*')
    {
        return $field == '*' ? $this->data : @$this->data[$field];
    }

    public function getTime()
    {
        return @$this->getData($this->routes['time']);
    }

    public function getTitle()
    {
        return $this->getData($this->routes['title']);
    }

    public function getShortTitle($preset = false)
    {
        return $this->getData($this->routes['shortTitle']);
    }

    public function getDescription()
    {
        return $this->getData($this->routes['description']);
    }

    public function getPosition()
    {
	    return $this->getData($this->routes['position']);
    }

    public function getTitleAddon()
    {
        return $this->getData($this->routes['titleAddon']);
    }

    public function getSideLabel()
    {
        return false;
    }

    public function getShortLabel()
    {
        return $this->getData($this->routes['label']);
    }

    public function getFullLabel()
    {
        return $this->getLabel();
    }

    public function getLabel()
    {
        return $this->getData($this->routes['label']);
    }

    public function getHlText()
    {
        return str_replace("\r", "<br/>", $this->hl);
    }

    public function getUrl($options = array())
    {
        $output = '/dane/' .
            $this->getDataset() . '/' .
            $this->getId();

        if( $slug = $this->getSlug() )
        	$output .= ',' . $slug;

        return $output;

    }

    public function getId()
    {
        return $this->getData('id');
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getSentence() {

	    return @$this->contexts[0]['sentence'];

    }

    public function getAction() {

	    return @$this->contexts[0]['action'];

    }

    public function getCreator($field = '*') {

	    $creator = @$this->contexts[0]['creator'];

	    if( $field=='*' )
	    	return $creator;
	    else
	    	return @$creator[ $field ];

    }

    public function getThumbnailUrl($size = 'default')
    {
        return false;
    }

	public function getIcon()
    {
	    $class = strtolower(array_pop(explode('\\', get_class($this))));
        return '<span class="object-icon icon-datasets-' . $class . '"></span>';
    }

    public function getHeaderThumbnailUrl($size = 'default')
    {
        return false;
    }

    public function hasHighlights()
    {
        return true;
    }

    public function forceHighlightsFields()
    {
	    return false;
    }

    public function getHighlightsFields()
    {
	    return array();
    }

    public function getTinyLabel() {
	    return $this->tiny_label;
    }

	public function getHiglightedFields( $fields = false, $fieldsPush = false )
	{
		$output = array();

		if( is_array($fieldsPush) )
			$fieldsPush = $fieldsPush[0];

		$fields = ($fields===false) ? $this->hl_fields : $fields;
		if(
			$fieldsPush &&
			!in_array($fieldsPush, $fields) &&
			( $schema = $this->getSchemaForFieldname( $fieldsPush ) ) &&
			!( isset($schema[3]) && isset($schema[3]['noHl']) && $schema[3]['noHl'] )
		)
			array_unshift($fields, $fieldsPush);


		if( !empty($fields) )
			foreach( $fields as $fieldname )
				if( $schema = $this->getSchemaForFieldname( $fieldname ) )
					$output[ $fieldname ] = array(
						'label' => $schema[1],
						'type' => isset($schema[2]) ? $schema[2] : 'string',
						'value' => $this->getData($fieldname),
						'options' => isset($schema[3]) ? $schema[3] : 'string',
					);

        return $output;
    }

    public function getSchemaForFieldname($fieldname)
    {
        $output = false;

        if ($fieldname && !empty($this->schema)) {
            foreach ($this->schema as $s) {
                if ($s[0] == $fieldname) {
                    $output = $s;
                    break;
                }
            }
        }

		return $output;
	}

	public function addRoutes( $routes = array() )
	{
		$this->routes = array_merge($this->routes, $routes);
	}

	public function setOptions($options)
	{
		$this->options = array_merge($this->options, $options);
		return $this->options;
	}

    public function __call($func, $arg)
    {

	    // debug('__call'); debug($func);

        $func = str_replace('get', '', $func);
        $func = lcfirst($func);
        if (!empty($arg)) {
            $arg = array_pop($arg);
            return (isset($this->{$func}[$arg])) ? $this->{$func}[$arg] : false;
        }
        return $this->$func;
    }

    public function getBreadcrumbs()
    {
	    return array();
    }

    public function getDefaultColumnsSizes() {
	    return array(2, 10);
    }
    
    public function getPageDescription() {
	    return $this->_pageDescription ? $this->getMetaDescription('page') : false;
    }
	
	public function getImgPageDescription() {
	    return false;
    }
	
}
