<?

namespace MP\Lib;

class Miejsca extends DataObject
{
	
	protected $tiny_label = 'Miejsce';
	
    protected $routes = array(
        'title' => 'title',
    );
    
    public function getTitle() {
	    
	    $title_parts = array();
	    
	    if( $this->getData('miejscowosc') )
	    	$title_parts[] = $this->getData('miejscowosc');
	    	
	    if( $this->getData('ulica') )
	    	$title_parts[] = $this->getData('ulica');
	    	    
	    return implode(', ', $title_parts);
	    
    }

}