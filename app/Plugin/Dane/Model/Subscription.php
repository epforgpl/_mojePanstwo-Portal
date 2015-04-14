<?

class Subscription extends AppModel {
	
    public $useDbConfig = 'mpAPI';
	
	public function save($data = array()) {
		
		if(
			!empty($data) 
		) {
			
			return $this->getDataSource()->request('dane/subscriptions', array(
				'method' => 'POST',
				'data' => $data,
			));
									
		}
				
	}
	
	public function delete($id) {
		
		if(
			!empty($id) 
		) {
			
			return $this->getDataSource()->request('dane/subscriptions/' . $id, array(
				'method' => 'DELETE',
			));
									
		}
				
	}
	
	public function load($id) {
		
		if(
			!empty($id) 
		) {
			
			return $this->getDataSource()->request('dane/subscriptions/' . $id);
									
		}
				
	}
	
}