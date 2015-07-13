<?

namespace MP\Lib;

class Powiaty extends DataObject
{

    protected $tiny_label = 'Powiat';

    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Powiat';
    }
    
    public function getTitle() {
	    
	    if( $this->getData('typ_id')=='1' )
	    	return 'Powiat ' . $this->getData('nazwa');
	    else
	    	return $this->getData('nazwa');
	    		    
    }
    
    public function getShortTitle() {
	    return $this->getTitle();
    }

    public function hasHighlights()
    {
        return false;
    }

}