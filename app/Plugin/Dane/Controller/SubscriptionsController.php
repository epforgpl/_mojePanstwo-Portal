<?
		
	class SubscriptionsController extends AppController {
	
		public $uses = array('Dane.Subscription');
	    public $components = array('RequestHandler');
				
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
	