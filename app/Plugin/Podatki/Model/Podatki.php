<?

require_once(APPLIBS . 'Dataobject.php');

class Podatki extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getData()
    {

        $res = $this->getDataSource()->request('podatki/getData', array(
            'method' => 'GET',
        ));

        return $res;

    }
    
    public function sendData( $data )
    {

        $res = $this->getDataSource()->request('podatki/sendData', array(
            'method' => 'POST',
            'data' => $data,
        ));

        return $res;

    }

}
