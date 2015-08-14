<?php

class Document extends AppModel
{

    public $useDbConfig = 'mpAPI';
    public $useTable = false;

    public function load($id, $options = array())
    {
	    	    	    	    
        try {
            return $this->getDataSource()->loadDocument($id, $options);
        } catch (Exception $e) {
            return false;
        }

    }

}
