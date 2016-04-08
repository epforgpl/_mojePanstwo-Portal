<?

class Kultura extends AppModel
{

    public $useDbConfig = 'mpAPI';
		
    public function getData($id, $params)
    {
	    	    
	    $query = array();
	    $fields = array('sex', 'age', 'education', 'region', 'city_size', 'household', 'size');
	    
	    foreach( $fields as $f )
		    if( isset($params[$f]) && ($params[$f]!='-') )
		    	$query[ $f ] = $params[$f];
				
        return $this->getDataSource()->request('kultura/data/' . $id . '?' . http_build_query($query));
        
    }

}
