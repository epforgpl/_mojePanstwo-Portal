<?php

class Document extends AppModel {

	public $useDbConfig = 'mpAPI';
	public $useTable = false;
	
	// function to load document content's package. if package === 0, then we are loading whole content.
	
	public function load($id, $package = 1) {

		try {
			return $this->getDataSource()->loadDocument($id, $package);
		} catch (Exception $e) {
			return false;
		}

	}

}
