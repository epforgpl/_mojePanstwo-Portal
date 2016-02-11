<?

namespace MP\Lib;

class Ngo_konkursy extends DataObject
{
			
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'czas_utowrzenia',
        'description' => false,
    );
    
    protected $hl_fields =array(
    	'symbol', 'beneficjent_nazwa', 'wartosc_ogolem', 'dofinansowanie_ue'
    );
		
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $date = $this->getData('ngo_konkursy.czas_utowrzenia') )
			$output[] = dataSlownie( substr($date, 0, 10) );
	
		return $output;
		
	}
	
	public function getThumbnailUrl($size = false)
    {
	    return 'http://sds.tiktalik.com/portal/ngo_konkursy/' . $this->getId() . '_1.jpg';
    }
    
    public function getPageThumbnailUrl()
    {
	    return 'http://sds.tiktalik.com/portal/ngo_konkursy/' . $this->getId() . '_3.jpg';
    }
    
    public function getImgPageDescription()
    {
	    return $this->getData('opis');
    }
    
    public function getPageDescription()
    {
	    return false;
    }
    
}