<?


class Sejmometr extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function autorzy_projektow($params = array())
    {
        return $this->getDataSource()->request('sejmometr/autorzy_projektow');
    }

    public function zawody()
    {
        return $this->getDataSource()->request('sejmometr/zawody');
    }

    public function getStats()
    {
        return $this->getDataSource()->request('sejmometr/stats');
    }

    public function okregi() {
        return $this->getDataSource()->request('sejmometr/okregi');
    }

    /*
    public function getLatestData()
    {
        $ret = $this->getDataSource()->request('sejmometr/latestData');

        if( !empty($ret) ) {
            foreach( $ret as $key => &$val ) {
                if( isset($val['dataobjects']) && !empty($val['dataobjects']) ) {
                    foreach( $val['dataobjects'] as &$object ) {

                        $object = $this->Dane()->interpretateObject( $object );

                    }
                }
            }
        }

        return $ret;
    }
    */

}




