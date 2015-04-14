<?
App::uses( 'Session', 'Controller/Component' );

class mpapiObjectsSource extends DataSource {

	public $description = 'API platformy _mojePaństwo do obsługi obiektów danowych';

	public $config = array(
		'key' => '',
	);

	public function __construct( $config ) {
		$this->API = mpapiComponent::getAPI();
		parent::__construct( $config );
	}

	public function read( Model $model, $queryData = array(), $recursive = null ) {
		
		$conditions = $queryData['conditions'];
		$this->API  = $this->API->Dane();

		if ( @$conditions['dataset'] && is_string( $conditions['dataset'] ) ) {

			$dataset = $conditions['dataset'];
			unset( $queryData['conditions']['dataset'] );
			$this->API->searchDataset( $conditions['dataset'], $queryData );

		} elseif ( @$conditions['datachannel'] && is_string( $conditions['datachannel'] ) ) {

			$dataset = $conditions['datachannel'];
			unset( $queryData['conditions']['datachannel'] );
			$this->API->searchDatachannel( $conditions['datachannel'], $queryData );

		} else {

			$this->API->search( $queryData );

		}

		// debug( $this->API->lastResponseBody );

		return array(
			'objects'    => $this->API->getObjects(),
			'pagination' => $this->API->getPagination(),
			'facets'     => $this->API->getFacets(),
			'didyoumean' => $this->API->getDidyoumean(),
		);

	}

}