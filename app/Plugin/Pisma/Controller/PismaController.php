<?php
	
App::uses('ApplicationsController', 'Controller');
class PismaController extends ApplicationsController
{
	
	public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Nowe pismo',
			),
			array(
				'id' => 'moje',
				'label' => 'Moje pisma',
			),
		),
		'title' => 'Pisma',
		'subtitle' => 'Wysyłaj pisma urzędowe do instytucje publicznych',
		'headerImg' => 'pisma',
	);
	
    public $helpers = array('Form');
    public $uses = array('Pisma.Pismo');
    public $components = array('RequestHandler');

    public function prepareMetaTags() {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/pisma/img/social/pisma.jpg');
    }

    public function view($id, $slug = '')
    {
        $pismo = $this->load($id);
        
        if( $pismo['is_owner'] )
	        $this->setMenuSelected('moje');
    }
	
	private function load($id)
	{

		try {

			$pismo = $this->Pismo->documents_read($id);			
			$is_owner = false;
			
			if(
				(
					( $this->Auth->user() ) && 
					( $pismo['from_user_type'] == 'account' ) && 
					( $this->Auth->user('id') == $pismo['from_user_id'] )
				) || (
					( !$this->Auth->user() ) && 
					( $pismo['from_user_type'] == 'anonymous' ) && 
					( session_id() == $pismo['from_user_id'] )
				)
			)
				$is_owner = true;
			
			$pismo['is_owner'] = $is_owner;
			
			$this->title = $pismo['name'];
	        $this->set('pismo', $pismo);
			
	        return $pismo;

        } catch (Exception $e) {
						
	        $this->set('title_for_layout', 'Pismo nie istnieje lub nie masz do niego dostępu');
		    $this->render('not_found');
		    return false;

        }

    }
    
    public function edit($id, $slug='')
    {
	    
		if( $pismo = $this->load($id) ) {
						
			if( !$pismo['is_owner'] )
				return $this->redirect( $this->referer() );
					
			if( $pismo['saved'] ) {
				$this->setMenuSelected('moje');
			} else {
				$this->setMenuSelected();
			}
		
		} else {
			
			$this->set('title_for_layout', 'Pismo nie istnieje lub nie masz do niego dostępu');
		    $this->render('not_found');
			
		}
				      
    }

    public function share($id, $slug = '')
    {
        $this->load($id); 
    }
    
    public function html($id, $slug='')
    {
		
		$pismo = $this->load($id);

		$view = new View($this, false);
		$html = $view->element('html', array(
			'pismo' => $pismo,
		));
		echo $html; die();
    }
	
	public function put($id, $slug=false) {
		
		$params = array();
		if( !$this->Auth->user() )			
			$params['anonymous_user_id'] = session_id();
		
		$status = false;
		
		if( isset($this->request->data['name']) ) {
			
			$params['name'] = $this->request->data['name'];
			$status = $this->Pismo->documents_partial_update($id, $params);
			
		}
		
		$this->set('status', $status);
		$this->set('_serialize', 'status');
		
	}
	
	public function post($id, $slug=false) {
		
		$redirect = 'object';
		
		$params = array();
		if( !$this->Auth->user() )			
			$params['anonymous_user_id'] = session_id();
								
		if( isset($this->request->data['delete']) ) {
			
			$this->Pismo->documents_delete($id, $params);
			$redirect = 'my';
			
		} elseif( isset($this->request->data['save']) ) {
			
			$doc = $this->request->data;
			
			$doc = array_merge($doc, $params);
			unset( $doc['save'] );
			
			$this->Pismo->documents_update($id, $doc);
			
		} elseif( isset($this->request->data['send']) ) {
			
			$this->Pismo->documents_send($id);
			
		} elseif( isset($this->request->data['access']) ) {
			
			$this->Pismo->documents_change_access($id, $this->request->data['access']);
			
		}
				
		if( $redirect=='object' ) {
			
			$url = '/pisma/' . $id;
			if( $slug )
				$url .= ',' . $slug;
				
			return $this->redirect($url);
			
		} elseif( $redirect=='my' ) {
			
			return $this->redirect('/pisma/moje');
			
		}
				
	}
	
	public function create()
    {
		
		$pismo = array();
						
        if (isset($this->request->data['adresat_id']))
            $pismo['adresat_id'] = $this->request->data['adresat_id'];
            
        if (isset($this->request->data['szablon_id']))
            $pismo['szablon_id'] = $this->request->data['szablon_id'];
		
		if( !$this->Auth->user() )
			$this->Session->write('Pisma.transfer_anonymous', true);
				
        $status = $this->Pismo->documents_create($pismo);        
        return $this->redirect( $status['url'] . '/edit' );
    
    }
	
	public function home()
    {
	    
	    $this->setMenuSelected();
	    
	    /*
        $API = $this->Pismo;

        $templatesGroups = $API->templates_grouped();
        $this->set('templatesGroups', $templatesGroups);
		*/
		
        $query = array_merge($this->request->query, $this->request->params);
		
        $pismo = array(
            'szablon_id' => isset($query['szablon_id']) ? $query['szablon_id'] : false,
            'adresat_id' => isset($query['adresat_id']) ? $query['adresat_id'] : false,
        );
		
		/*
        if ($session = $this->Session->read('Pisma.unsaved')) {
            $this->set('pismo', $session);
            $this->Session->delete('Pisma.unsaved');
        }
        */

        $this->set('pismo_init', $pismo);
    }
	
    public function my()
    {
		
		$q = false;
		
		$params = array(
			'page' => (
				isset($this->request->query['page']) && 
				is_numeric($this->request->query['page'])
			) ? $this->request->query['page'] : 1,
		);
		
		if(
			isset( $this->request->query['q'] ) &&
			$this->request->query['q']
		) 
			$q = $params['q'] = $this->request->query['q'];
		
		if( $user = $this->Auth->user() ) {
			
		} else {
			
			$params['anonymous_user_id'] = session_id();
			
		}
		
        $search = $this->Pismo->documents_search($params);
        // debug($search); die();
        $this->set('search', $search);
        $this->set('q', $q);
        $this->set('title_for_layout', 'Moje pisma');
        $this->setMenuSelected('moje');
    }	
	
	/*
    public function save()
    {

        if (isset($this->request->data['send'])) {


            $pismo = $this->Pismo->save($this->request->data);
            if ($pismo && isset($pismo['id']) && $pismo['id']) {

                $this->redirect($pismo['url']);

            }

        } elseif (isset($this->request->data['save'])) {

            $pismo = $this->Pismo->save($this->request->data);
            if ($pismo && isset($pismo['id']) && $pismo['id']) {

                $this->redirect($pismo['url']);

            }

        } elseif (isset($this->request->data['print'])) {

            $pismo = $this->Pismo->generatePDF($this->request->data);

        }

    }    
	
    private function saveForm($data)
    {
        try {
            $doc = $this->api->document_save($data);

        } catch (MP\ApiValidationException $ex) {

            // TODO nie widać flash w layoucie
            $this->Session->setFlash('Wystąpiły błędy walidacji', null, array('class' => 'alert-error'));
            $this->set('verr', $ex->getValidationErrors());
            $this->set('doc', $data);
            $this->render('edit');

            return null;
        }

        if (isset($data['saveAndSend'])) {
            $this->api->document_send($doc['id']);
        }

        return $doc;
    }
    */
    
}