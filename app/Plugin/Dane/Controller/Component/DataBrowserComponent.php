<?php
class DataBrowserComponent extends Component {
	
	public $settings = array();
	public $conditions = array();
	private $Dataobject = false;
	
	public function __construct($collection, $settings) {
		
		$this->settings = $settings;
			
	}
	
	public function beforeRender($controller){
		
		if( isset( $controller->request->query['q'] ) ) {
			$controller->request->query['conditions']['q'] = $controller->request->query['q'];
		}
			
		$this->queryData = $controller->request->query;
		
		if( !property_exists($controller, 'Dataobject') )
			$controller->Dataobject = ClassRegistry::init('Dane.Dataobject');
		
		$controller->Paginator->settings = $this->getSettings();		
		$hits = $controller->Paginator->paginate('Dataobject');
	    $controller->set('dataBrowser', array(
		    'hits' => $hits,
		    'aggs' => $controller->Dataobject->getAggs(),
	    ));
		
	}
	
	
	private function getSettings() {
		
		$conditions = $this->getSettingsForField('conditions');
		
		$output = array(
			'paramType' => 'querystring',
			'conditions' => $conditions,
			'aggs' => $this->getSettingsForField('aggs'),
		);
				
		if( isset($conditions['q']) )
			$output['highlight'] = true;
		
		return $output;
		
	}
	
	private function getSettingsForField($field) {
		
		$params = isset( $this->queryData[$field] ) ? $this->queryData[$field] : array();
				
		if( isset($this->settings[$field]) )
			$params = array_merge($params, $this->settings[$field]);
			
		return $params;
		
	}
	
}