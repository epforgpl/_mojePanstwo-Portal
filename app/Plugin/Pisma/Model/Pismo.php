<?

class Pismo extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function documents_create($data)
    {

        $res = $this->getDataSource()->request('pisma/documents', array(
            'method' => 'POST',
            'data' => $data,
        ));

        return $res;

    }

    public function documents_read($id, $params = array())
    {

        $res = $this->getDataSource()->request('pisma/documents/' . $id, array(
            'method' => 'GET',
            'data' => $params,
        ));
        
        $code = (int)$this->getDataSource()->Http->response->code;
        if ($code >= 400) {

            throw new NotFoundException();

        } else {
            return $res;
        }
    }

    public function transfer_anonymous($anonymous_user_id)
    {

        $res = $this->getDataSource()->request('pisma/transfer_anonymous', array(
            'method' => 'GET',
            'data' => array(
                'anonymous_user_id' => $anonymous_user_id,
            ),
        ));

        return $res;

    }

    public function documents_search($params)
    {

        $res = $this->getDataSource()->request('pisma/documents', array(
            'method' => 'GET',
            'data' => $params,
        ));

        return $res;

    }

    public function documents_update($id, $doc)
    {

        $res = $this->getDataSource()->request('pisma/documents/' . $id, array(
            'method' => 'POST',
            'data' => $doc,
        ));

        return $res;

    }

    public function documents_partial_update($id, $doc)
    {
        return $this->getDataSource()->request('pisma/documents/' . $id, array(
            'method' => 'PUT',
            'data' => $doc,
        ));
    }

    public function documents_change_access($id, $access)
    {
        return $this->getDataSource()->request('pisma/documents/' . $id, array(
            'method' => 'PUT',
            'data' => array(
                'access' => $access,
            ),
        ));
    }


    public function documents_delete($id, $params = array())
    {

        $res = $this->getDataSource()->request('pisma/documents', array(
            'data' => array(
                'id' => $id,
            ),
            'method' => 'DELETE',
        ));

        return $res;

    }

    public function documents_send($id, $data = array())
    {
        return $this->getDataSource()->request('pisma/documents/' . $id . '/send', array(
            'method' => 'POST',
            'data' => $data,
        ));
    }

    public function templates_grouped()
    {
        return $this->getDataSource()->request('pisma/templates/grouped');
    }

    public function templates_read($id)
    {
        return $this->getDataSource()->request('pisma/templates/' . $id);
    }
    
    public function templates_index($params){
	    return $this->getDataSource()->request('pisma/templates', array(
		    'data' => $params,
	    ));
    }

    public function setDocumentName($id, $name) {
        return $this->getDataSource()->request('pisma/documents/setDocumentName/' . $id, array(
            'method' => 'POST',
            'data' => array(
                'name' => $name
            ),
        ));
    }

}