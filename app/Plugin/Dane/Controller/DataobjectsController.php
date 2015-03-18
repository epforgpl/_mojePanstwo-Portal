<?

class DataobjectsController extends AppController
{
    
    public $uses = array('Dane.Dataobject');
    
    public $initLayers = array();    
    public $objectOptions = array(
        'hlFields' => false,
    );
    
    public $microdata = array(
        'itemtype' => 'http://schema.org/Intangible',
        'titleprop' => 'name',
    );
    
    public function view($dataset = false, $id = false, $slug = '') {
	    
	    if(
		    $dataset && 
		    $id && 
		    is_numeric($id) 
	    ) {
	    	
	    	$layers = $this->initLayers;
	    	$layers[] = 'dataset';
	    	    
		    if( $object = $this->Dataobject->find('first', array(
			    'conditions' => array(
				    'dataset' => $dataset,
				    'id' => $id,
			    ),
			    'layers' => $layers,
		    )) ) {
			    
			    $dataset = $object->getLayer('dataset');
								
	            $this->set('object', $object);
	            $this->set('objectOptions', $this->objectOptions);
	            $this->set('microdata', $this->microdata);	
	            $this->set('title_for_layout', $object->getTitle());
	
	            if ($desc = $object->getDescription())
	                $this->setMetaDescription($desc);
			    
		    }
	    
	    } else {
		    throw new BadRequestException();
	    }
	    
    }

}