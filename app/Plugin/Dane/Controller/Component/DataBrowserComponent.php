<?php
class DataBrowserComponent extends Component {
	
	public $settings = array();
	public $conditions = array();
	private $Dataobject = false;
	
	public function __construct($collection, $settings) {
		
		$this->settings = $settings;
			
	}
	
	public function beforeRender($controller){
		
		$this->queryData = $controller->request->query;
		
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