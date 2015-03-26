<?

class BDL extends AppModel
{
    
    public $useDbConfig = 'mpAPI';
    
    public function getDataForDimmesions($dims, $podgrupa_id)
    {
	    $data = $this->getDataSource()->request('bdl/dataForDimmesions', array(
		    'method' => 'GET',
		    'data' => array(
			    'dims' => $dims,
			    'podgrupa_id' => $podgrupa_id,
		    ),
	    ));
		
        return @$data['data'];
    }

}