<?

class Finanse extends AppModel
{

    public $useDbConfig = 'mpAPI';
	
	public function getCompareData($p1, $p2) {
		
		$data = $this->getDataSource()->request('finanse/getCompareData', array(
			'data' => array(
				'p1' => $p1,
				'p2' => $p2,
			),
		));
        return $data;
		
	}
	
    public function getBudgetData()
    {
        $data = $this->getDataSource()->request('finanse/getBudgetData');
        return $data;
    }
    
    public function getTables($id)
    {
        $data = $this->getDataSource()->request('finanse/getTables/' . $id);
        return $data;
    }

    public function getCommunePopCount($id) {
        $data = $this->getDataSource()->request('finanse/getCommunePopCount/' . $id);
        return $data;
    }
    
    public function getSpendings($year) {
        $data = $this->getDataSource()->request('finanse/getSpendings/' . $year);
        return $data;
    }

}
