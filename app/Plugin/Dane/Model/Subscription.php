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
	
}