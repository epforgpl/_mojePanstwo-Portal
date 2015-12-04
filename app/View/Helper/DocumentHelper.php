<?php

class DocumentHelper extends AppHelper
{

    public function place($id, $options = array())
    {
		
		$_options = array();
		
		if( $options ) {
		
			if( $options=='*' )
				$_options['package'] = '*';
			elseif( is_numeric($options) )
				$_options['package'] = $options;
			else
				$_options = array_merge(array(
					'package' => 1,
				), $options);
		
		} else {
			
			$_options = array(
				'package' => 1,
			);
			
		}
		
		$options = $_options;		
		
		App::import("Model", "Document");  
		$Document = new Document();  
									
		$doc = $Document->load($id, $options);
		
        return $this->_View->element('Document/view', array(
            'document' => $doc,
            'toolbar' => isset( $options['toolbar'] ) ? $options['toolbar'] : true,
        ));
        
    }

}