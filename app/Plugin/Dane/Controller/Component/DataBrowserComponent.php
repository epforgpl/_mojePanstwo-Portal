<?php
class DataBrowserComponent extends Component {
	
	public $settings = array();
	public $conditions = array();
	private $Dataobject = false;
	
	public function __construct($collection, $settings) {
		
		$this->settings = $settings;
			
	}

    private function getCancelSearchUrl($controller) {
        if(!isset($controller->request->query) || count($controller->request->query) === 0)
            return $controller->here;

        $query = $controller->request->query;

        if(isset($query['q']))
            unset($query['q']);

        if(isset($query['page']))
            unset($query['page']);

        if(isset($query['conditions']['q']))
            unset($query['conditions']['q']);

        if(count(array_count_values($query)) > 0 || count($query['conditions']) > 0)
            $query = '?' . http_build_query($query);
        else
            $query = '';

        return $controller->here . $query;
    }
	
	public function beforeRender($controller){
		
		if( isset( $controller->request->query['q'] ) )
			$controller->request->query['conditions']['q'] = $controller->request->query['q'];
			
		$this->queryData = $controller->request->query;

        $controller->set('cancelSearchUrl', $this->getCancelSearchUrl($controller));

		if( !property_exists($controller, 'Dataobject') )
			$controller->Dataobject = ClassRegistry::init('Dane.Dataobject');
		
		$controller->Paginator->settings = $this->getSettings();		
		$objects = $controller->Paginator->paginate('Dataobject');
	    $controller->set('dataBrowser', array(
		    'objects' => $objects,
	    ));
		
	}
	
	
	private function getSettings() {
				
		return array(
			'paramType' => 'querystring',
			'conditions' => $this->getSettingsForField('conditions'),
		);
		
	}
	
	private function getSettingsForField($field) {
		
		$params = isset( $this->queryData[$field] ) ? $this->queryData[$field] : array();
				
		if( isset($this->settings[$field]) )
			$params = array_merge($params, $this->settings[$field]);
			
		return $params;
		
	}
	
}