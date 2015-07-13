<?php

class SolrAppModel extends AppModel {
	public $useDbConfig = 'mpapiObjects';
	public $pagination = array();
	public $facets = array();
	public $didyoumean = false;

	public function afterFind( $results, $primary = false ) {

		$this->pagination;
		if ( isset( $results['pagination'] ) ) {
			$this->pagination = $results['pagination'];
			$this->total      = ( isset( $results['pagination']['total'] ) ) ? $results['pagination']['total'] : 0;
			unset( $results['pagination'] );

		}

		$this->facets = array();
		if ( isset( $results['facets'] ) ) {
			$this->facets = $results['facets'];
			unset( $results['facets'] );
		}

		$this->didyoumean = false;
		if ( isset( $results['didyoumean'] ) ) {
			$this->didyoumean = $results['didyoumean'];
			unset( $results['didyoumean'] );
		}

		foreach ( $results['objects'] as &$object ) {
			$object = array( $this->alias => $object );
		}

		return $results['objects'];
	}

	public function paginateCount( $conditions = null, $recursive = 0, $extra = array() ) {
		return $this->total;
	}
} 