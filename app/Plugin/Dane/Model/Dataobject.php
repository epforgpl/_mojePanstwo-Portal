<?

// APP::uses('MP\Lib\Dataobject', 'Lib');
require_once(APPLIBS . 'Dataobject.php');

class Dataobject extends AppModel
{

    public $useDbConfig = 'mpAPI';

    /*
    public function subscribe($object_id, $user_id) {

        return $this->getDataSource()->request('dane/dataobjects/' . $object_id . '/subscribe', array(
            'method' => 'GET',
            'user_id' => $user_id,
        ));

    }
    */

    public function afterFind($results = array(), $primary = false)
    {
				
        for ($i = 0; $i < count($results); $i++) {
			
			
            $class = ucfirst($results[$i]['dataset']);
            $file = APPLIBS . 'Dataobject/' . $class . '.php';

            if (file_exists($file)) {
                require_once($file);
                $class = 'MP\\Lib\\' . $class;
                $obj = new $class($results[$i]);
            } else
                $obj = new MP\Lib\Dataobject($results[$i]);

            $results[$i] = $obj;

        }

        return $results;
    }

    public function getAggs()
    {

        return $this->getDataSource()->Aggs;

    }
    
    public function getApps()
    {

        return $this->getDataSource()->Apps;

    }

    public function getPerformance()
    {

        return $this->getDataSource()->took / 1000;

    }

    public function paginateCount($model, $conditions = null, $recursive = 0)
    {

        return $this->getDataSource()->count;

    }

    public function suggest($q, $params = array())
    {

        if (!isset($params['dataset']))
            $params['dataset'] = false;

        return $this->getDataSource()->request('dane/suggest', array(
            'method' => 'GET',
            'data' => array(
                'q' => $q,
                'dataset' => $params['dataset']
            ),
        ));

    }

    public function subscribe($dataset, $id)
    {

        return $this->getDataSource()->request('dane/' . $dataset . '/' . $id . '/subscribe', array(
            'method' => 'POST',
        ));

    }

    public function unsubscribe($dataset, $id)
    {

        return $this->getDataSource()->request('dane/' . $dataset . '/' . $id . '/unsubscribe', array(
            'method' => 'POST',
        ));

    }

}