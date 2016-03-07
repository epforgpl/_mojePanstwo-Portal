<?

class Srodowisko extends AppModel
{

    public $useDbConfig = 'mpAPI';
		
    public function getData($param)
    {
        $data = $this->getDataSource()->request('srodowisko/data?param=' . $param);
        return $data;
    }

}
