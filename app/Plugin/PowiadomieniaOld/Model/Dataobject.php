<?

class Dataobject extends AppModel
{
    public $pagination = array();
    public $total = 0;

    public function find($type = 'first', $queryData = array())
    {
        $this->API = mpapiComponent::getApi()->Powiadomienia();
        $results = $this->API->search($queryData);

        $this->pagination = $this->API->getPagination();

        return $this->API->getObjects();
    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array())
    {
        return $this->pagination['total'];
    }

}