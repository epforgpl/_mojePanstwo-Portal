<?php

class DocumentHelper extends AppHelper
{

    public function place($id)
    {
		
		App::import("Model", "Document");  
		$Document = new Document();  
		
		if( $doc = $Document->load($id) ) {
						
	        return $this->_View->element('Document/view', array(
	            'document' => $doc,
	        ));
        
        } else return '';
        
    }

}