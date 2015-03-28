<?php
class DataFeedComponent extends Component {
	
	public $settings = array();
	public $conditions = array();
	public $order = array();
	private $Dataobject = false;
	
	public function __construct($collection, $settings) {
				
		$this->settings = $settings;
		
	}
	
	public function beforeRender($controller){
		
		$controller->helpers[] = 'Dane.Dataobject';
		
		if( is_null($controller->Paginator) ) {
			$controller->Paginator = $controller->Components->load('Paginator');
		}
		
		if( isset( $controller->request->query['q'] ) ) {
			$controller->request->query['conditions']['q'] = $controller->request->query['q'];
		}
			
		$this->queryData = $controller->request->query;

		if( !property_exists($controller, 'Dataobject') )
			$controller->Dataobject = ClassRegistry::init('Dane.Dataobject');
		
		$controller->Paginator->settings = $this->getSettings();
		// $controller->Paginator->settings['order'] = 'score desc';
		// debug($controller->Paginator->settings); die();	
		$hits = $controller->Paginator->paginate('Dataobject');

	    $controller->set('dataFeed', array(
		    'hits' => $hits,
		    'preset' => $this->settings['preset'],
	    ));
		
	}
	
	
	private function getSettings() {
		
		$conditions = $this->getSettingsForField('conditions');
		
		$output = array(
			'paramType' => 'querystring',
			'conditions' => $conditions,
			'feed' => $this->settings['feed'],
		);
		
		if( isset($this->settings['channel']) )
			$output['channel'] = $this->settings['channel'];
						
		if( isset($this->settings['context']) )
			$output['context'] = $this->settings['context'];
				
		if( isset($conditions['q']) )
			$output['highlight'] = true;
		
		return $output;
		
	}
	
	private function getSettingsForField($field) {
		
		$params = isset( $this->queryData[$field] ) ? $this->queryData[$field] : array();
				
		if( isset($this->settings[$field]) ) {
			if( is_array($this->settings[$field]) )
				$params = array_merge($params, $this->settings[$field]);
			else
				$params = $this->settings[$field];
		}
		
		return $params;
		
	}
	
}