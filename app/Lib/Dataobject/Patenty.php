<?

namespace MP\Lib;

class Patenty extends DataObject
{
	
    public $force_hl_fields = true;

	protected $schema = array(
		array('uprawniony', 'Uprawniony', 'string'),
		array('tworcy', 'Twórcy', 'string'),		
	);
    
    protected $hl_fields = array(
    	'uprawniony', 'tworcy'
    );
	
	protected $tiny_label = 'Patent';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
    );

    public function getLabel()
    {	    
        return 'Patent';
    }
		
	public function getThumbnailUrl($size = 3) {
		
		if( $this->getData('img')=='1' )
			return 'http://public.sds.tiktalik.com/patenty/img/' . $this->getId() . '.png';
		else
			return false;
		
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
					
		$output = array();
		
		if( $date = $this->getDate() )
			$output[] = 'Zarejestrowano ' . dataSlownie($date);
		
		return $output;
		
	}
	
}