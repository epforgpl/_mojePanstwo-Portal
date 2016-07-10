<?

namespace MP\Lib;

class Osoby_publiczne extends DataObject
{
	
	public $_pageDescription = false;
    protected $tiny_label = 'Osoba publiczna';
        
    public function getShortTitle()
    {
        return $this->getTitle();
    }

    public function getTitle()
    {
	    $output = array();
	    
	    if( $this->getData('tytul') )
        	$output[] = $this->getData('tytul');
        	
        if( $this->getData('nazwa') )
        	$output[] = $this->getData('nazwa');
	    
        return implode(' ', $output);
    }

    public function getLabel()
    {
        return 'Osoba publiczna';
    }

    public function getMetaDescriptionParts($preset = false)
    {
		
		$output = array();
        return $output;

    }
}
