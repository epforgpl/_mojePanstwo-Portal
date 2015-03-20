<?php
App::uses('CakeTime', 'Utility');
App::uses('DataobjectsController', 'Dane.Controller');

class DatasetsController extends DataobjectsController
{

    public $uses = array('Dane.Dataobject');
	
    public $components = array(
        // 'RequestHandler',
        'Paginator'
    );
    
    private $redirects_map = array(
	    'prawo' => 'prawo',
	    'prawo_hasla' => 'prawo/tematy',
	    'prawo_urzedowe' => 'prawo/urzedowe',
	    'prawo_wojewodztwa' => 'prawo/lokalne',
    );

    public function index()
    {
		
		/*
		return $this->redirect('/dane/zbiory');
        
        $datasets = $this->API->getDatasets();
        $this->set('datasets', $datasets);

        $this->set('title_for_layout', 'Zbiory danych publicznych');
        */

    }

    public function view($slug = false) {
	    
	    if( array_key_exists($slug, $this->redirects_map) ) {
		    
		    $url = '/' . $this->redirects_map[$slug];
		    
		    if( !empty( $this->request->query ) )
		    	$url .= '?' . http_build_query( $this->request->query );
		    		    
		    return $this->redirect($url);
		    
	    } else {
	     
		    if( $slug ) {
		    	
		    	$layers = $this->initLayers;
	   
			    if( $object = $this->Dataobject->find('first', array(
				    'conditions' => array(
					    'dataset' => 'zbiory',
					    'zbiory.slug' => $slug,
				    ),
				    'layers' => $layers,
			    )) ) {
				    								
		            $this->set('object', $object);
		            $this->set('objectOptions', $this->objectOptions);
		            $this->set('microdata', $this->microdata);	
		            $this->set('title_for_layout', $object->getTitle());
		
		            if ($desc = $object->getDescription())
		                $this->setMetaDescription($desc);
		                
		                
		            $this->Components->load('Dane.DataBrowser', array(
			            'conditions' => array(
				            'dataset' => $object->getData('slug'),
			            ),
			            'aggsPreset' => $object->getData('slug'),
		            ));
				    
			    }
		    
		    } else {
			    throw new BadRequestException();
		    }
	    
	    }
	    
    }
	
	/*
    public function beforeRender()
    {

        if ($this->request->params['action'] == 'view') {

            $data = $this->dataBrowser->dataset;

            if (!$data) {
                throw new NotFoundException('Could not find that post');
            }

            $dataset = $data['Dataset'];
            $datachannel = $data['Datachannel'];

            $this->set('_APPLICATION', $data['App']);

            $this->addStatusbarCrumb(array(
                'text' => $datachannel['nazwa'],
                'href' => '/dane/kanal/' . $datachannel['slug'],
            ));


            $title_for_layout = $dataset['name'];
            $this->set('title_for_layout', $title_for_layout);

        }

    }
    */

}