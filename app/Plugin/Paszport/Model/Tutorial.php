<?
	
class Tutorial extends AppModel
{

    public $useDbConfig = 'mpAPI';

	public function index() {
		
		return $this->getDataSource()->request('paszport/tutorials/index');
		
	}
	
	public function edit($id, $data) {
		
		return $this->getDataSource()->request('paszport/tutorials/' . $id, array(
			'data' => $data,
			'method' => 'POST',
		));
		
	}
	
}