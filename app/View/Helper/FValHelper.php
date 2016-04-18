<?php

class FValHelper extends AppHelper
{

    public function val( $inp, $type ) {
	    
	    
	    if( $type == 'float' ) {
		    
		    $inp = (float) $inp;
		    if( $inp )
			    return '<span class="nmbr">' . str_replace(' ', '&nbsp;', number_format(round($inp, 1), 1, ',', ' ')) . '</span>';
			else
				return '';
				
		} elseif( $type == 'int' ) {
		    
		    $inp = str_replace(' ', '', $inp);
		    $inp = (int) $inp;
		    if( $inp )
			    return '<span class="nmbr">' . str_replace(' ', '&nbsp;', number_format($inp, 0, ',', ' ')) . '</span>';
			else
				return '';
				
		} elseif( $type == 'int_str' ) {
		    
		    if( $inp )
			    return $inp; 
			else
				return '';
			
		} elseif( $type == 'percent' ) {
		    
		    $inp = (float) $inp;
		    if( $inp==100 )
		    	return '100%';
		    elseif( !$inp )
		    	return '';
		    else
			    return '<span class="nmbr">' . str_replace(' ', '&nbsp;', number_format(round($inp, 1), 1, ',', '&nbsp;')) . '%</span>';
		    
	    } else {
	    
		    return $inp;
	    
	    }
		    
	        
	    
    }

}