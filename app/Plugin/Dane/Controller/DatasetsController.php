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
		            'aggs' => array(
			            'typ_id' => array(
				            'terms' => array(
					            'field' => 'prawo.typ_id',
					            'exclude' => array(
						            'pattern' => '0'
					            ),
				            ),
				            'aggs' => array(
					            'typ_nazwa' => array(
						            'terms' => array(
							            'field' => 'data.prawo.typ_nazwa',
						            ),
					            ),
				            ),
				            'visual' => array(
					            'label' => 'Typy aktów prawnych',
					            'skin' => 'pie_chart',
				            ),
			            ),
                        'typ_id_horizontal' => array(
                            'terms' => array(
                                'field' => 'prawo.typ_id',
                                'exclude' => array(
                                    'pattern' => '0'
                                ),
                            ),
                            'aggs' => array(
                                'typ_nazwa' => array(
                                    'terms' => array(
                                        'field' => 'data.prawo.typ_nazwa',
                                    ),
                                ),
                            ),
                            'visual' => array(
                                'label' => 'Typy aktów prawnych',
                                'skin' => 'columns_horizontal',
                            ),
                        ),
                        'typ_id_vertical' => array(
                            'terms' => array(
                                'field' => 'prawo.typ_id',
                                'exclude' => array(
                                    'pattern' => '0'
                                ),
                            ),
                            'aggs' => array(
                                'typ_nazwa' => array(
                                    'terms' => array(
                                        'field' => 'data.prawo.typ_nazwa',
                                    ),
                                ),
                            ),
                            'visual' => array(
                                'label' => 'Typy aktów prawnych',
                                'skin' => 'columns_vertical',
                            ),
                        ),
			            'date' => array(
				            'date_histogram' => array(
					            'field' => 'date',
					            'interval' => 'year',
					            'format' => 'yyyy-MM-dd',
				            ),
				            'visual' => array(
					            'label' => 'Daty',
					            'skin' => 'date_histogram',
				            ),
			            ),
		            ),
	            ));
			    
		    }
	    
	    } else {
		    throw new BadRequestException();
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