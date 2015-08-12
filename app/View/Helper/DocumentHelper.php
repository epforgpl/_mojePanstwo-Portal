<?php

class DocumentHelper extends AppHelper
{

    public function place($id, $options = array())
    {
		
		App::import("Model", "Document");  
		$Document = new Document();  
		
		$full = isset($options['full']) ? (boolean) $options['full'] : false;
		
		if( is_numeric($id) )
			$doc = $Document->load($id, $full);
		else
			$doc = $id;
		
        return $this->_View->element('Document/view', array(
            'document' => $doc,
        ));
        
    }

}