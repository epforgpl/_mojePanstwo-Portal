<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_dzielnice_rady_posiedzenia extends DataObject
{
	
	protected $tiny_label = 'Samorząd';
		
	protected $schema = array(
		array('numer', 'Numer posiedzenia'),
	);
	
    protected $routes = array(
        'date' => 'data',
    );
    
    /*
    protected $hl_fields = array(
    	'gminy.rada_nazwa', 'numer', 'liczba_debat',
    );
    */
	
	public function __construct($params = array())
    {

        parent::__construct($params);

        $this->data['fullTitle'] = 'Sesja <strong>' . $this->getData('krakow_sesje.str_numer') . '</strong> - Posiedzenie <strong>#' . $this->getData('numer') . '</strong>';

    }
	
    public function getLabel()
    {
        return 'Posiedzenie Rady Miasta Kraków';
    }

    public function getThumbnailUrl($size = '3')
    {
    	if( $this->getData('yt_video_id') )
	        return 'http://img.youtube.com/vi/' . $this->getData('yt_video_id') . '/mqdefault.jpg';
	    else
	        return '/dane/pk/posiedzenie.jpg';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/dzielnice/' . $this->getData('dzielnica_id') . '/rada_posiedzenia/' . $this->getId();
    }
    
    public function getShortTitle() {
	    
	    return dataSlownie( $this->data['data'] );
	    
    }
    
    public function getTitle() {
	    
	    return $this->getData('dzielnice.nazwa') . ' | ' . dataSlownie($this->getDate()) . ' | Posiedzenie rady dzielnicy';
	    
    }
    
    public function getShortLabel() {
	    
	    return 'Posiedzenie rady dzielnicy ' . $this->getData('dzielnice.nazwa');
	    
    }

}