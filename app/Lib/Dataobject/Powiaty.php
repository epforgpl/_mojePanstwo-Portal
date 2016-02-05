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
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		
		if( $w = $this->getData('wojewodztwa.nazwa') )
			$output[] = 'Województwo ' . mb_strtolower(mb_substr($w, 0, 1)) . mb_substr($w, 1);
	
		return $output;
		
	}

}