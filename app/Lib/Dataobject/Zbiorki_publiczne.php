<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Zbiorki_publiczne extends DocDataObject
{
	
	protected $tiny_label = 'Zbiórki publiczne';
	
	public function getShortTitle() {
		return $this->getData('nazwa_zbiorki');
	}
	
	public function getTitle() {
		return $this->getShortTitle();
	}
    
    public function getDescription() {
	    return $this->getData('dane_opis_celu');
    }
    
    public function getPageDescription() {
	    return $this->getDescription();
    }
	
    public function getLabel() {
        return 'Zbiórki publiczne';
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		if( $date = $this->getData('data_wplywu') )
			$output[] = dataSlownie( $date );
	
		return $output;
		
	}
		
}