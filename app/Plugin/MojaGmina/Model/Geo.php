<?

class Geo extends AppModel
{
    
    public $useDbConfig = 'mpAPI';

    public function wojewodztwa()
    {
	    
	    $res = $this->getDataSource()->request('geo/wojewodztwa', array(
	    	'method' => 'GET',
    	));
    	    	
    	return $res;
    }

    public function powiaty($id = null)
    {
        if (is_null($id)) {
            return false;
        }
        $res = $this->getDataSource()->request('geo/powiaty/' . $id, array(
	    	'method' => 'GET',
    	));
    	    	
    	return $res;
    }

    public function gminy($id = null)
    {
        if (is_null($id)) {
            return false;
        }
        $res = $this->getDataSource()->request('geo/gminy/' . $id, array(
	    	'method' => 'GET',
    	));
    	    	
    	return $res;
    }

    public function resolve($lat = null, $lng = null)
    {
        if (is_null($lat) || is_null($lng)) {
            return false;
        }
        
        $res = $this->getDataSource()->request("geo/resolve", array(
	    	'method' => 'GET',
	    	'data' => array(
		    	'lat' => $lat,
		    	'lng' => $lng,
	    	),
    	));
    	    	
    	return $res;        
    }
    
}