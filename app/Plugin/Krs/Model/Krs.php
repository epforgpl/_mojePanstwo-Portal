<?

require_once(APPLIBS . 'Dataobject.php');

class Krs extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getPKDSection($id)
    {

        return $this->getDataSource()->request('krs/pkdsections/' . $id, array(
            'method' => 'GET',
        ));

    }
    
    
	
	
}