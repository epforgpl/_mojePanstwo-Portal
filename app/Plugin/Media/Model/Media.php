<?

require_once( APPLIBS . 'Dataobject.php' );
require_once( APPLIBS . 'Dataobject/Twitter.php' );

class Media extends AppModel
{
    
    public $useDbConfig = 'mpAPI';
    
    public function getTwitterStats($range)
    {
						
    	$res = $this->getDataSource()->request('Media/getTwitterStats/' . $range, array(
	    	'method' => 'GET',
    	));
    	
    	return $res;

    }
    
    public function getTwitterAccountsTypes()
    {
						
    	$res = $this->getDataSource()->request('Media/getTwitterAccountsTypes', array(
	    	'method' => 'GET',
    	));
    	
    	return $res;

    }
    
    public function getTwitterTweetsGroupByTypes($range, $types, $sort)
    {
		
		$data = $this->getDataSource()->request('Media/getTwitterTweetsGroupByTypes', array(
	    	'method' => 'GET',
	    	'data' => array(
	            'range' => $range,
	            'types' => $types,
	            'sort' => $sort,
	        ),
    	));
		        
        if (is_array($data) && !empty($data)) {
            foreach ($data as &$d) {

                if (isset($d['search'])
                    // && isset($data['search']['dataobjects'])
                    // && is_array($data['search']['dataobjects'])
                    // && !empty($data['search']['dataobjects'])
                ) {

                    $objects = array();
                    foreach ($d['search'] as $dataobject) {                        
                        
                        $objects[] = new MP\Lib\Twitter( $dataobject );                        
                        
                    }
                    $d['objects'] = $objects;
                    unset($d['search']);

                }
            }
        }
				
        return $data;

    }

}