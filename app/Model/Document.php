<?php

class Document extends AppModel {

	public $useDbConfig = 'mpAPI';
	public $useTable = false;

	public function load($id, $package = 1) {

		try {
			return $this->getDataSource()->loadDocument($id, $package);
		} catch (Exception $e) {
			return false;
		}

	}

}
