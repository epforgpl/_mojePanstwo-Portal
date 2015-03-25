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
    	    	
    	return $res;	    
    
    }
    
    public function transfer_anonymous($params) {
	    
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
	    
        return $this->request('documents', $params);
    }
    
    public function documents_update($id, $doc) {
        
        $res = $this->getDataSource()->request('pisma/documents/' . $id, array(
	    	'method' => 'POST',
	    	'data' => $doc,
    	));
    	       	
    	return $res;
    	    	
    }
    
    public function documents_partial_update($id, $doc) {
        return $this->request('documents/' . $id, $doc, 'PUT');
    }
    
    public function documents_delete($id, $params = array()) {
        
        $res = $this->getDataSource()->request('pisma/documents/' . $id, array(
	    	'method' => 'DELETE',
    	));
    	       	
    	return $res;
    	
    }
    
    public function documents_send($id) {
        return $this->request('documents/' . $id . '/send', null, 'POST');
    }
        
    public function templates_grouped() {
        return $this->request('templates/grouped');
    }
    
    public function templates_read($id) {
        return $this->request('templates/' . $id);
    }

}