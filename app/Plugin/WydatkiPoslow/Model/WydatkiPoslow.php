<?


class WydatkiPoslow extends AppModel
{
    
    public $useDbConfig = 'mpAPI';
    
    public function getStats()
    {
							
    	$res = $this->getDataSource()->request('wydatkiposlow/stats', array(
	    	'method' => 'GET',
    	));
    	    	
    	return $res;

    }
    
}