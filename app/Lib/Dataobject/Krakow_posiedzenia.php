<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_posiedzenia extends DocDataObject
{
	
	protected $tiny_label = 'Samorząd';
		
	protected $schema = array(
		array('numer', 'Numer posiedzenia'),
	);
	
    protected $routes = array(
        'title' => 'data',
        'shortTitle' => 'data',
        'date' => 'data',
        'description' => 'desc',
    );
    
    /*
    protected $hl_fields = array(
    	'gminy.rada_nazwa', 'numer', 'liczba_debat',
    );
    */
	
	public function __construct($params = array())
    {

        parent::__construct($params);

        $this->data['desc'] = '<span class="light">Kadencja <strong>' . $this->getData('kadencja_id') . '</strong> <span class="separator">|</span> Sesja <strong>' . $this->getData('krakow_sesje.str_numer') . '</strong> <span class="separator">|</span> Posiedzenie <strong>#' . $this->getData('numer') . '</strong><span>';

    }
	
    public function getLabel()
    {
        return 'Posiedzenie Rady Miasta Kraków';
    }

    public function getThumbnailUrl($size = '3')
    {
    	if( $this->getData('preview_yt_id') )
	        return 'http://img.youtube.com/vi/' . $this->getData('preview_yt_id') . '/mqdefault.jpg';
	    else
	        return '/dane/pk/posiedzenie.jpg';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903/posiedzenia/' . $this->getId();
    }
    
    public function getShortLabel() {
	    
	    return 'Posiedzenie Rady Miasta';
	    
    }
    
    public function getShortTitle() {
	    return $this->dataSlownie( $this->getData('data') );
    }
    
    public function getTitle() {
	    return $this->getShortTitle() . ' - Posiedzenie Rady Miasta Kraków';
    }

}