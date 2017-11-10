<?php

class DocumentHelper extends AppHelper
{

    public function place($id, $options = array()) {
	    
	    $options = $this->getOptions($options);		
		App::import("Model", "Document");  
		$Document = new Document();  
									
		$doc = $Document->load($id, $options['package']);
		
        return $this->_View->element('Document/view', array(
            'document' => $doc,
            'toolbar' => isset( $options['toolbar'] ) ? $options['toolbar'] : true,
        ));
	    
    }
    
    public function place2($id, $options = array()) {
	    
	    $options = $this->getOptions($options);		
		App::import("Model", "Document");  
		$Document = new Document();  
									
		$doc = $Document->load($id, $options['package']);
		$css = $Document->loadCss($id);
				
        return $this->_View->element('Document/view', array(
            'document' => $doc,
            'toolbar' => isset( $options['toolbar'] ) ? $options['toolbar'] : true,
            'css' => $css,
        ));
	    
    }
    
    private function getOptions($options = array()) {
	    
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
		
		return $_options;	
	    
    }

}