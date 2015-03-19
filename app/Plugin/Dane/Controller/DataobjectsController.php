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
    
    public function loadDocument($document_id, $variable = 'document') {
	    
	    debug( $document_id );
	    $this->set($variable, $document_id);
	    
    }
    
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
    
    public function view() {
	    	    
	    $this->load();
	    
    }

}