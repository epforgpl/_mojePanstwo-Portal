<?

class BdlTempItem extends AppModel
{

    public $useTable = false;

    public function find($type = 'first', $params = array())
    {
        $ret=null;
        switch($type){
            case 'first':{
                break;
            }
            case 'all':{
                break;
            }
            case 'list':{
                break;
            }
            case 'count':{
                break;
            }
        }
    }

    public function findById($id)
    {
        return $this->find('first', array('conditions'=>array('id'=>$id)));
    }

    public function save()
    {

    }

    public function delete()
    {

    }

}