<?

class Finanse extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getBudgetData()
    {
        $data = $this->getDataSource()->request('finanse/getBudgetData');
        return $data;
    }

    public function getCommunePopCount($id) {
        $data = $this->getDataSource()->request('finanse/getCommunePopCount/' . $id);
        return $data;
    }

}
