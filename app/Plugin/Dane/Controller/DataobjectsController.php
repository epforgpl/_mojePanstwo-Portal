<?

class DataobjectsController extends AppController
{
    
    public $uses = array('Dane.Dataobject');
    
    public $object = false;
    public $initLayers = array();    
    public $objectOptions = array(
        'hlFields' => false,
    );
    
    public $microdata = array(
        'itemtype' => 'http://schema.org/Intangible',
        'titleprop' => 'name',
    );
    
    public $menu = array();
            
    public function load() {
	    
	    $dataset = isset( $this->request->params['pass'][0] ) ? $this->request->params['pass'][0] : false;
	    $id = isset( $this->request->params['pass'][1] ) ? $this->request->params['pass'][1] : false;
	    $slug = isset( $this->request->params['pass'][2] ) ? $this->request->params['pass'][2] : '';
	    
	    if(
		    $dataset && 
		    $id && 
		    is_numeric($id) 
	    ) {
	    	
	    	$layers = $this->initLayers;
	    	$layers[] = 'dataset';
	    	    
		    if( $this->object = $this->Dataobject->find('first', array(
			    'conditions' => array(
				    'dataset' => $dataset,
				    'id' => $id,
			    ),
			    'layers' => $layers,
		    )) ) {
			    
			    $dataset = $this->object->getLayer('dataset');
								
	            $this->set('object', $this->object);
	            $this->set('objectOptions', $this->objectOptions);
	            $this->set('microdata', $this->microdata);	
	            $this->set('title_for_layout', $this->object->getTitle());
	
	            if ($desc = $this->object->getDescription())
	                $this->setMetaDescription($desc);
			    
		    }
	    
	    } else {
		    throw new BadRequestException();
	    }
	    
    }
    
    public function addInitLayers($layers) {

        if (is_array($layers)) {
            $this->initLayers = array_merge($this->initLayers, $layers);
        } else {
            $this->initLayers[] = $layers;
        }

    }
    
    public function _prepareView() {
		return $this->load();    
    }
    
    public function view() {
	    $this->load();
    }
        
    public function feed() {
	    
    }
    
    public function beforeRender() {
	    
	    $selected = $this->request->params['action'];
	    if( $selected=='view' )
	    	$selected = '';
	    
	    $this->menu['selected'] = $selected;   
	    $this->menu['base'] = $this->object->getUrl();   
	    
	    $this->set('object_menu', $this->menu);	    
	    
    }

}