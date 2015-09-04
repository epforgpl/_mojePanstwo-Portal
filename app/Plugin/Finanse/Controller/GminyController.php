<?php

App::uses('AppController', 'Controller');

class GminyController extends AppController {

    public $uses = array(
        'Finanse.GminaBudzet'
    );

    public $components = array('RequestHandler');

    public function dzialy($gmina_id, $typ) {
        $this->set(array(
            'dzialy' => $this->GminaBudzet->getDzialy($gmina_id, $typ),
            '_serialize' => 'dzialy',
        ));
    }

    public function dzial($id, $gmina_id, $typ) {
        
        $liczba_ludnosci = 750000;
		$przedzial = array(
			'min' => 500000,
			'max' => 1000000,
		);
		        
        $this->loadModel('Dane.Dataobject');
        $this->Dataobject->find('all', array(
	        'limit' => 0,
	        'aggs' => array(
		        'gminy' => array(
			        'filter' => array(
				        'range' => array(
					        'data.gminy.liczba_ludnosci' => array(
						        'gte' => $przedzial['min'],
						        'lt' => $przedzial['max']
					        ),
				        ),
			        ),
			        'aggs' => array(
				        'wydatki' => array(
					        'nested' => array(
						        'path' => 'gminy-wydatki',
					        ),
					        'aggs' => array(
						        'histogram' => array(
							        'histogram' => array(
								        'field' => 'suma_wydatki',
								        'interval' => 10000,
							        ),
							        'aggs' => array(
								        'suma_wydatki' => array(
									        'sum' => array(
										        'field' => 'wydatki',
									        ),
								        ),
							        ),
						        ),						        
					        ),
				        ),
			        ),
		        ),
	        ),
	        'conditions' => array(
		        'dataset' => 'gminy',
	        ),
        ));
        
        $aggs = $this->Dataobject->getAggs();
        
        $this->set(array(
            'dzial' => $aggs,
            '_serialize' => array('dzial'),
        ));
    }

}