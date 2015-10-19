<?

require_once(APPLIBS . 'Dataobject.php');

class Mapa extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function geodecode($lat, $lon)
    {

        return $this->getDataSource()->request('Mapa/geodecode', array(
            'method' => 'GET',
            'data' => array(
	            'lat' => $lat,
	            'lon' => $lon,
            ),
        ));

    }
    
    public function obwody($id)
    {

        return $this->getDataSource()->request('Mapa/obwody', array(
            'method' => 'GET',
            'data' => array(
	            'id' => explode(',', $id)
            ),
        ));

    }
    
    public function getCode($code)
    {

        return $this->getDataSource()->request('Mapa/kody/' . $code, array(
            'method' => 'GET',
        ));

    }
	
	
}