<?

class BdlTempItem extends AppModel
{

    public $useTable = false;

    public function find($type = 'first', $params = array())
    {
        $ret = null;
        if ($this->Session->check('TempItems')) {
            return false;
        }

        $ret = $this->Session->read('TempItems');

        if (isset($params['conditions'])) {

        }

        if (isset($params['order'])) {
            if ($params['order'] == 'DESC') {
                $ret = array_reverse($ret);
            }
        }

        if ($ret == null) {
            return false;
        }

        switch ($type) {
            case 'first': {
                return $ret[0];
                break;
            }
            case 'all': {
                return $ret;
                break;
            }
            case 'list': {
                $ret2 = array();
                foreach ($ret as $key => $val) {
                    array_merge($ret2, array($key => $val['nazwa']));
                }
                return $ret2;
                break;
            }
            case 'count': {
                return count($ret);
                break;
            }
        }
    }

    public function findById($id)
    {
        return $this->find('first', array('conditions' => array('id' => $id)));
    }

    public function save($data)
    {

    }

    public function delete($id)
    {
        unset();
    }

}