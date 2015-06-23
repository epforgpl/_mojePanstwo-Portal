<?

class ZamowieniaPubliczne extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getAggs($params)
    {

        $res = $this->getDataSource()->request('zamowieniapubliczne/aggs', array(
            'method' => 'GET',
            'data' => $params,
        ));

        return $res;

    }

}