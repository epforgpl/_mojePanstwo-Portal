<?php

App::uses('Sanitize', 'Utility');
App::uses('ApplicationsController', 'Controller');

class KodyPocztoweController extends ApplicationsController
{
    public $uses = array('KodyPocztowe.KodPocztowy', 'Dane.Dataobject');
    public $components = array('Session', 'Paginator', 'RequestHandler');
	
	public $settings = array(
		'title' => 'Kody pocztowe',
		// 'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce',
		// 'headerImg' => 'prawo',
	);
	
    public function index()
    {

        $details = false;
        $mstr = @$this->request->query['mstr'];
        $mid = @$this->request->query['mid'];
        $kod = @$this->request->query['kod'];

        $this->set('mstr', $mstr);
        $this->set('mid', $mid);
        $this->set('kod', $kod);

        if ($kod) {
	        
	        $code = $this->Dataobject->find('first', array(
		        'conditions' => array(
			        'dataset' => 'kody_pocztowe',
			        'kody_pocztowe.kod' => $kod,
		        ),
	        ));
	        
	        debug($code); die();
	        
            $code = $this->API->searchCode($kod);

            if ($code && $code['object_id']) {
                $this->redirect(array(
                    'plugin' => 'Dane',
                    'controller' => 'kody_pocztowe',
                    'action' => 'view',
                    'id' => $code['object_id']
                ));
            } else {
                $this->Session->setFlash('Podany kod pocztowy nie zostały odnaleziony');
            }
        } elseif ($mid) {

            $details = true;
            $miejscowosc = $this->API->Dane()->getObject('miejscowosci', $mid);
            $this->set('miejscowosc', $miejscowosc->getData());

            $ustr = @$this->request->query['ustr'];
            $this->set('ustr', $ustr);

            if ($miejscowosc) {
                $this->addStatusbarCrumb(array(
                    'text' => $miejscowosc->getData('nazwa'),
                ));
                $adresy = $this->API->searchAddresses($miejscowosc->getId(), $ustr);
                $this->set('adresy', $adresy);
            }


        } elseif ($mstr) {
            $details = true;
            $this->paginate = array(
                'conditions' => array(
                    'dataset' => 'miejscowosci',
                    'q' => Sanitize::stripAll($mstr),
                ),
                'paramType' => 'querystring',
            );
            $miejscowosci = $this->Paginator->paginate('Dataobject');
            $pagination = $this->Dataobject->pagination;
            $total = $this->Dataobject->total;
            if (!$total) {
                $this->Session->setFlash('Podana miejscowość nie została odnaleziona');
            } elseif ($total === 1 && ($mid = $miejscowosci[0]['Dataobject']->object_id)) {
                $this->redirect('/kody_pocztowe?mstr=' . $mstr . '&mid=' . $mid);
            } else {
                $this->set('miejscowosci', $miejscowosci);
            }
            $this->set(compact('pagination', 'total'));
        }

        $this->set('details', $details);

        $application = $this->getApplication();
        $this->set('title_for_layout', $application['name']);

    }

    public function adres()
    {

        if (isset($this->request->params['ext']) && ($this->request->params['ext'] == 'json')) {

            $search = array();

            $q = @$this->request->query['q'];
            if ($q) {
	            

	            $objects = $this->Dataobject->find('all', array(
		            'conditions' => array(
			            'dataset' => 'kody_pocztowe_ulice',
			            'q' => $q,
		            ),
	            ));
	                            

                foreach ($objects as $obj) {

                    $text = $obj->getData('miejscowosci.nazwa');

                    switch ($obj->getData('typ_id')) {
                        case '2': {
                            $text .= ', ulica';
                            break;
                        }
                        case '3': {
                            $text .= ', Plac';
                            break;
                        }
                        case '4': {
                            $text .= ', Osiedle';
                            break;
                        }
                        case '5': {
                            $text .= ', Aleja';
                            break;
                        }
                        case '6': {
                            $text .= ', Skwer';
                            break;
                        }
                        case '7': {
                            $text .= ', Wybrzeże';
                            break;
                        }
                    }

                    if ($obj->getData('ulica')) {
                        $text .= ' ' . $obj->getData('ulica');
                    }

                    $score = @$obj->getLayer('score');

                    $s = array(
                        'id' => $obj->getId(),
                        'text' => $text,
                        'score' => @$score['value'],
                    );

                    if ($obj->getData('miejscowosci.nazwa') != $obj->getData('miejscowosci.nazwa_gminy')) {
                        $s['desc'] = $obj->getData('miejscowosci.nazwa_gminy');
                    }

                    $search[] = $s;
                }
            }

            $this->set('search', $search);
            $this->set('_serialize', array('search'));

        } elseif (isset($this->request->params['adres_id']) && $this->request->params['adres_id']) {

            $adres = $api->getObject('kody_pocztowe_ulice', $this->request->params['adres_id']);
            $adres->loadLayer('kody');
            $this->set('adres', $adres);

        } else {
            $this->redirect('/kody_pocztowe');
        }
    }

} 