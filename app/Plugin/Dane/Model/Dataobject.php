<?

// APP::uses('MP\Lib\Dataobject', 'Lib');
require_once(APPLIBS . 'Dataobject.php');
require_once(APPLIBS . 'Collection.php');
require_once(APPLIBS . 'Letter.php');

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
			
			if( !isset($results[$i]['_type']) || ($results[$i]['_type']=='objects') ) {
								
	            $class = ucfirst($results[$i]['dataset']);
	            $file = APPLIBS . 'Dataobject/' . $class . '.php';
								
	            if (file_exists($file)) {
	                require_once($file);
	                $class = 'MP\\Lib\\' . $class;
	                $obj = new $class($results[$i]);
	            } else
	                $obj = new MP\Lib\Dataobject($results[$i]);
                
            } elseif( $results[$i]['_type']=='collections' ) {
	            
	            $obj = new MP\Lib\Collection($results[$i]);
	            
            } elseif( $results[$i]['_type']=='letters' ) {
	            
	            $obj = new MP\Lib\Letter($results[$i]);
	            
            }
						
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

    public function paginateCount($model = false, $conditions = null, $recursive = 0)
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