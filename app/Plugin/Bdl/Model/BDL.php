<?

class BDL extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getData($params)
    {
        $data = $this->getDataSource()->request('bdl/data', array(
            'method' => 'GET',
            'data' => $params,
        ));

        return @$data;
    }

    public function getCombination($params)
    {

        if (is_string($params))
            $params = array(
                'id' => $params,
            );

        $data = $this->getDataSource()->request('bdl/combinations', array(
            'method' => 'GET',
            'data' => $params,
        ));

        return @$data;
    }

    /*
    public function getLocalDataForDimension($dim_id, $level)
    {

        $data = $this->getDataSource()->request('bdl/localDataForDimension/' . $dim_id, array(
            'method' => 'GET',
            'data' => array(
                'level' => $level,
            ),
        ));

        return @$data['data'];

    }
	*/

    /*
    public function getChartDataForDimmesions($dims)
    {
        $data = $this->getDataSource()->request('bdl/chartDataForDimmesions', array(
            'method' => 'GET',
            'data' => array(
                'dims' => $dims,
            ),
        ));

        return @$data['data'];
    }

    public function getDataForDimmesions($dims, $podgrupa_id)
    {
        $data = $this->getDataSource()->request('bdl/dataForDimmesions', array(
            'method' => 'GET',
            'data' => array(
                'dims' => $dims,
                'podgrupa_id' => $podgrupa_id,
            ),
        ));

        return @$data['data'];
    }



    public function getDataForDimension($dim_id)
    {
        $data = $this->getDataSource()->request('bdl/dataForDimmesion/' . $dim_id, array(
            'method' => 'GET',
        ));

        return @$data['data'];
    }
    */


    public function getLocalChartDataForDimmesions($dimid, $localtype, $localid)
    {
        $data = $this->getDataSource()->request('bdl/getLocalDataForDimension/', array(
            'method' => 'GET',
            'data' => array(
                'dimid' => $dimid,
                'localtype' => $localtype,
                'localid' => $localid
            ),
        ));

        return @$data['data'];
    }

    public function getTree()
    {

        $data = $this->getDataSource()->request('bdl/tree', array(
            'method' => 'GET',
        ));

        return $data;

    }

}
