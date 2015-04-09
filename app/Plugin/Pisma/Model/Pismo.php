<?

class Pismo extends AppModel
{
    
    public $useDbConfig = 'mpAPI';
    
    public function documents_create($data)
    {

    	$res = $this->getDataSource()->request('pisma/documents', array(
	    	'method' => 'POST',
	    	'data' => $data,
    	));
    	    	
    	return $res;

    }
	
	public function documents_read($id, $params = array()) {
	    
	    $res = $this->getDataSource()->request('pisma/documents/' . $id, array(
	    	'method' => 'GET',
	    	'data' => $params,
    	));
    	
    	$code = (int) $this->getDataSource()->Http->response->code;
    	if( $code>=400 ) {
	    	
	    	throw new NotFoundException();
	    	
    	} else { 	    	
	    	return $res;	    
		}
    }
    
    public function transfer_anonymous($temp_user_id) {
	    
	    // debug($temp_user_id); die();
	    
	    $res = $this->getDataSource()->request('pisma/transfer_anonymous', array(
	    	'method' => 'GET',
	    	'data' => $params,
    	));
    	    	
    	return $res;
    	
    }
	
    public function documents_search($params) {
	    
	    $res = $this->getDataSource()->request('pisma/documents', array(
	    	'method' => 'GET',
	    	'data' => $params,
    	));
    	    	
    	return $res;

    }
    
    public function documents_update($id, $doc) {
        
        $res = $this->getDataSource()->request('pisma/documents/' . $id, array(
	    	'method' => 'POST',
	    	'data' => $doc,
    	));
    	       	
    	return $res;
    	    	
    }
    
    public function documents_partial_update($id, $doc) {
        return $this->getDataSource()->request('documents/' . $id, $doc, 'PUT');
    }
    
    public function documents_delete($id, $params = array()) {
        
        $res = $this->getDataSource()->request('pisma/documents/' . $id, array(
	    	'method' => 'DELETE',
    	));
    	       	
    	return $res;
    	
    }
    
    public function documents_send($id) {
        return $this->getDataSource()->request('pisma/documents/' . $id . '/send', array(
	        'method' => 'POST',
        ));
    }
        
    public function templates_grouped() {
        return $this->getDataSource()->request('pisma/templates/grouped');
    }
    
    public function templates_read($id) {
        return $this->getDataSource()->request('pisma/templates/' . $id);
    }

}