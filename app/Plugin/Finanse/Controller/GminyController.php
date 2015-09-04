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
			'min' => 0,
			'max' => 10000000,
		);
		
		        
        $this->loadModel('Dane.Dataobject');
        $this->Dataobject->find('all', array(
	        'limit' => 0,
	        'aggs' => array(
		        'gmina' => array(
			        'filter' => array(
				        'term' => array(
					        'id' => $gmina_id,
				        ),
			        ),
			        'aggs' => array(
				        'wydatki' => array(
					        'nested' => array(
						        'path' => 'gminy-wydatki',
					        ),
					        'aggs' => array(
						        'dzial' => array(
							        'filter' => array(
								        'bool' => array(
									        'must' => array(
										        array(
											        'term' => array(
												        'gminy-wydatki.rok' => 2014,
											        ),
										        ),
										        array(
											        'term' => array(
												        'gminy-wydatki.kwartal' => 1,
											        ),
										        ),
										        array(
											        'term' => array(
												        'gminy-wydatki.dzial_id' => $id,
											        ),
										        ),
									        ),
								        ),
							        ),
							        'aggs' => array(
								        'rozdzialy' => array(
									        'terms' => array(
										        'field' => 'gminy-wydatki.rozdzial_id',
										        'size' => 100,
									        ),
									        'aggs' => array(
										        'nazwa' => array(
											        'terms' => array(
												        'field' => 'gminy-wydatki.rozdzial',
												        'size' => 1,
											        ),
										        ),
										        'wydatki' => array(
											        'sum' => array(
												        'field' => 'gminy-wydatki.wydatki',
											        ),
										        ),
									        ),
								        ),
							        ),
						        ),
					        ),
				        ),
			        ),
		        ),
		        'gminy' => array(
			        'filter' => array(
				        'range' => array(
					        'data.gminy.liczba_ludnosci' => array(
						        'gte' => $przedzial['min'],
						        'lt' => $przedzial['max']
					        ),
				        ),
			        ),
			        'scope' => 'global',
			        'aggs' => array(
				        'wydatki' => array(
					        'nested' => array(
						        'path' => 'gminy-wydatki-dzialy',
					        ),
					        'aggs' => array(
						        'timerange' => array(
							        'filter' => array(
								        'bool' => array(
									        'must' => array(
										        array(
											        'term' => array(
												        'gminy-wydatki-dzialy.rok' => 2014,
											        ),
										        ),
										        /*
										        array(
											        'term' => array(
												        'gminy-wydatki-dzialy.kwartal' => '0',
											        ),
										        ),
										        */
										        array(
											        'term' => array(
												        'gminy-wydatki-dzialy.id' => $id,
											        ),
										        ),
									        ),
								        ),
							        ),
							        'aggs' => array(
								        'min' => array(
									        'terms' => array(
										        'field' => 'gminy-wydatki-dzialy.wydatki',
										        'size' => '1',
										        'order' => array(
											        '_term' => 'asc',
										        ),
									        ),
									        'aggs' => array(
										        'reverse' => array(
											        'reverse_nested' => '_empty',
											        'aggs' => array(
												        'top' => array(
													        'top_hits' => array(
														        'size' => 1,
													        ),
												        ),
											        ),
										        ),
									        ),
								        ),
								        'max' => array(
									        'terms' => array(
										        'field' => 'gminy-wydatki-dzialy.wydatki',
										        'size' => '1',
										        'order' => array(
											        '_term' => 'desc',
										        ),
									        ),
									        'aggs' => array(
										        'reverse' => array(
											        'reverse_nested' => '_empty',
											        'aggs' => array(
												        'top' => array(
													        'top_hits' => array(
														        'size' => 1,
													        ),
												        ),
											        ),
										        ),
									        ),
								        ),
								        'histogram' => array(
									        'histogram' => array(
										        'field' => 'gminy-wydatki-dzialy.wydatki',
										        'interval' => 10000,
									        ),
									        'aggs' => array(
										        'reverse' => array(
											        'reverse_nested' => '_empty',
											        'aggs' => array(
												        
											        ),
										        ),
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