<?

class SubscriptionsController extends AppController
{

    public $uses = array('Dane.Subscription');
    public $components = array('RequestHandler');

    public function view($id)
    {

        if (
            ($data = $this->Subscription->load($id)) &&
            isset($data['Subscription'])
        ) {

            $url = $data['Subscription']['Subscription']['url'];
            $this->redirect($url);

        }

    }

    public function add()
    {
		
		if(
			isset( $this->request->data['channel'] ) && 
			( $this->request->data['channel']==array('') )
		)
			unset( $this->request->data['channel'] );
				
        $this->Subscription->save($this->request->data);
        $this->redirect($this->referer());

    }

    public function delete($id)
    {
				
        if ($this->Subscription->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
		
		if( !$this->request->is('ajax') ) {
		
			debug('not ajax');
			
			$url = str_replace('subscription=' . $id, '', $this->referer());		
	        $this->redirect( $url );
	        exit();
        
        }

        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
		
    }

}
	