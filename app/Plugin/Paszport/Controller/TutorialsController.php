<?
	
class TutorialsController extends PaszportAppController
{

    public $uses = array('Paszport.Tutorial');

    public function index() {
	    
	    $data = $this->Tutorial->index();
	    
	    $this->set('data', $data);
	    $this->set('_serialize', 'data');
	    
    }
    
    public function edit($id) {
	    
	    $data = $this->Tutorial->edit($id, $this->request->data);
	    
	    $this->set('data', $data);
	    $this->set('_serialize', 'data');
	    
    }

}
