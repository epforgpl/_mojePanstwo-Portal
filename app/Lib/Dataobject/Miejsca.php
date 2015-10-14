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
	    
	    if( $this->getData('typ_id')=='1' ) { // województwo
		    
		    return 'Województwo ' . $this->getData('wojewodztwo');
		    
	    } elseif( $this->getData('typ_id')=='2' ) { // powiat
		    
		    return 'Powiat ' . $this->getData('powiat');
		    
	    } elseif( $this->getData('typ_id')=='3' ) { // gmina
		    
		    return $this->getData('gmina');
		    
	    } elseif( $this->getData('typ_id')=='4' ) { // miejscowość
		    
		    return $this->getData('miejscowosc');
		    
	    } elseif( $this->getData('typ_id')=='5' ) { // miejscowość
		    
		    return $this->getData('miejscowosc'). ', ' . $this->getData('ulica');
		    
	    }	    
	    
    }

}