<?php

class DocumentHelper extends AppHelper
{

    public function place($id, $options = array())
    {
		
		if( is_numeric($options) )
			$options = array(
				'package' => $options,
			);
		elseif( !is_array($options) )
			$options = array();
		
		App::import("Model", "Document");  
		$Document = new Document();  
				
		$options['full'] = isset($options['full']) ? (boolean) $options['full'] : false;
		
		debug( $options ); die();
		
		if( is_numeric($id) )
			$doc = $Document->load($id, $options);
		else
			$doc = $id;
			
		debug($doc); die();
		
        return $this->_View->element('Document/view', array(
            'document' => $doc,
        ));
        
    }

}