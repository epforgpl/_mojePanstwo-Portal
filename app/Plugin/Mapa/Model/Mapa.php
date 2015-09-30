<?

require_once(APPLIBS . 'Dataobject.php');

class Mapa extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function geocode($q)
    {

        $res = $this->getDataSource()->request('Mapa/geocode?q=' . urlencode($q), array(
            'method' => 'GET',
        ));

        return $res;

    }
	
	
}