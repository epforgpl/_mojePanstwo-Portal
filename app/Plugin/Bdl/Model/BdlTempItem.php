<?

class BdlTempItem extends AppModel
{

    public $useTable = false;

    public $useDbConfig = 'mpAPI';

    public function save($data, $type)
    {

        $res = $this->getDataSource()->request('BDL/user_items', array(
            'method' => 'POST',
            'data' => $data,
            'type' => $type
        ));

        return $res;

    }

    public function delete($id, $type)
    {

        $res = $this->getDataSource()->request('BDL/user_items/'.$id, array(
            'method' => 'DELETE',
            'type' => $type,
        ));

        return $res;

    }

    public function searchList(){
        $res = $this->getDataSource()->request('BDL/user_items/list', array(
            'method' => 'GET'
        ));

        return $res;
    }

    public function searchById($id, $type){
        $res = $this->getDataSource()->request('BDL/user_items/'.$id, array(
            'method' => 'GET',
            'type' => $type,
        ));

        return $res;
    }

    public function searchAll($type='BDL'){
        $res = $this->getDataSource()->request('BDL/user_items/', array(
            'method' => 'GET',
            'type' => $type
        ));

        return $res;
    }

}