<?

require_once(APPLIBS . 'Dataobject.php');
require_once(APPLIBS . 'Dataobject/Twitter.php');

class Media extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getAccountsPropositions()
    {

        $res = $this->getDataSource()->request('Media/getAccountsPropositions', array(
            'method' => 'GET',
        ));

        return $res;

    }
    
    public function manage_account($data)
    {

        $res = $this->getDataSource()->request('Media/manage_account', array(
            'method' => 'POST',
            'data' => $data,
        ));

        return $res;

    }
	
	
	
}