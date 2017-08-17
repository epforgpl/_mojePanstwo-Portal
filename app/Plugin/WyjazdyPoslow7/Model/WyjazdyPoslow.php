<?


class WyjazdyPoslow extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getStats()
    {

        $res = $this->getDataSource()->request('wyjazdyposlow/stats', array(
            'method' => 'GET',
        ));

        return $res;

    }

}