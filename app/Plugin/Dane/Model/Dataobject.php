<?
	
class Dataobject extends AppModel {
	
    public $useDbConfig = 'mpAPI';
	
	public function subscribe($object_id, $user_id) {
		
		return $this->getDataSource()->request('dane/dataobjects/' . $object_id . '/subscribe', array(
			'method' => 'GET',
			'user_id' => $user_id,
		));
				
	}
	
}