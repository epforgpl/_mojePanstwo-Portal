<?

class Finanse extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getBudgetData()
    {
        $data = $this->getDataSource()->request('finanse/getBudgetData');
        return $data;
    }

}