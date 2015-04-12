<?php

class DocumentHelper extends AppHelper
{

    public function place($id)
    {
		
		App::import("Model", "Document");  
		$Document = new Document();  
		
		if( is_numeric($id) )
			$doc = $Document->load($id);
		else
			$doc = $id;
		
        return $this->_View->element('Document/view', array(
            'document' => $doc,
        ));
        
    }

}