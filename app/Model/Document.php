<?php

class Document extends AppModel
{

    public $useDbConfig = 'mpAPI';
    public $useTable = false;

    // function to load document content's package. if package === 0, then we are loading whole content.

    public function load($id, $options = array())
    {
	    
	    if( is_numeric($options) )
			$options = array(
				'package' => $options,
			);
		elseif( !is_array($options) )
			$options = array();
	    	    	    
	    if( !isset($options['package']) )
	    	$options['package'] = 1;
	    	    
        try {
            return $this->getDataSource()->loadDocument($id, $options);
        } catch (Exception $e) {
            return false;
        }

    }

}
