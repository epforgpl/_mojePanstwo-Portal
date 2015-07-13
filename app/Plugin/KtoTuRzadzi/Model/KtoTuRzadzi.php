<?

require_once(APPLIBS . 'Dataobject.php');

class KtoTuRzadzi extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getData()
    {

        $res = $this->getDataSource()->request('administracja/getData', array(
            'method' => 'GET',
        ));

        return $res;

    }

}