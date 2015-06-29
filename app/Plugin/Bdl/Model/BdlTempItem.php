<?

class BdlTempItem extends AppModel
{

    public $useTable = false;

    public function find($type = 'first', $params = array())
    {
        $ret = null;
        if (!CakeSession::check('TempItems')) {
            return false;
        }

        $ret = CakeSession::read('TempItems');

       // $ret = CakeSession::read();

        if (isset($params['conditions'])) {
            if (isset($params['conditions']['id'])) {
                $id = $params['conditions']['id'];
                $ret = Set::classicExtract($ret, $id);
            }
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

        return false;
    }

    public function findById($id)
    {
        return $this->find('first', array('conditions' => array('id' => $id)));
    }

    public function save($data)
    {
        if (CakeSession::check('TempItems')) {
            $ret = CakeSession::read('TempItems');
            array_merge($ret, $data);
        } else {
            $ret = $data;
        }
        if (CakeSession::write('TempItems', $ret)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        if (CakeSession::delete('TempItems.' . $id)) {
            return true;
        } else {
            return false;
        }
    }

}