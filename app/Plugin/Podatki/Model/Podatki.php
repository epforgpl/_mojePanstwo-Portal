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

}
