<?

class Ngo extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function addDeclaration($data)
    {

        return (boolean)$this->getDataSource()->request('Ngo/Declarations', array(
            'method' => 'POST',
            'data' => $data,
        ));

    }

}