<?

class BdlTempItem extends AppModel
{

    public $useTable = false;

    public function search($type = 'first', $params = array())
    {
        $ret = null;
        if (!CakeSession::check('TempItems')) {
            return false;
        }

        $ret = CakeSession::read('TempItems');

        if (isset($params['conditions'])) {
            if (isset($params['conditions']['id'])) {
                $id = $params['conditions']['id'];
                if ($id == 0) {
                    $ret = Set::classicExtract($ret, "$id");
                } else {
                    $ret = array(Set::classicExtract($ret, "$id"));
                }
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
               // debug($ret);
                foreach ($ret as $key => $val) {
                    $ret2[$key]=$val['tytul'];
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

    public function searchById($id)
    {
        return $this->search('first', array('conditions' => array('id' => $id)));
    }

    public function save($data)
    {
        if (isset($data['id'])) {
            if (CakeSession::write('TempItems.'.$data['id'], $data)) {
                return true;
            } else {
                return false;
            }
        }

        if (CakeSession::check('TempItems')) {
            $ret = CakeSession::read('TempItems');
            array_push($ret, $data);
        } else {
            $ret = array($data);
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