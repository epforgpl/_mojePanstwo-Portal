<?

namespace MP\Lib;

class Patenty extends DataObject
{
	
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
	
}