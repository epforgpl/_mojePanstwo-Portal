<?
		
	class SubscriptionsController extends AppController {
	
		public $uses = array('Dane.Subscription');
	    public $components = array('RequestHandler');
		
		public function view($id) {
			
			if( 
				( $data = $this->Subscription->load($id) ) && 
				isset( $data['Subscription'] )
			) {
				
				$url = $data['Subscription']['Subscription']['url'];
				$this->redirect($url);
				
			}
			
		}
		
		public function add() {
			
			$this->Subscription->save( $this->request->data );
			$this->redirect( $this->referer() );
			
		}
		
	    public function delete($id) {
	    		    	
	        if ($this->Subscription->delete($id)) {
	            $message = 'Deleted';
	        } else {
	            $message = 'Error';
	        }
	        	        
	        return $this->redirect( str_replace('subscription=' . $id, '', $this->referer()) );
	        	        
	        $this->set(array(
	            'message' => $message,
	            '_serialize' => array('message')
	        ));
	        
	    }
	    
	}
	