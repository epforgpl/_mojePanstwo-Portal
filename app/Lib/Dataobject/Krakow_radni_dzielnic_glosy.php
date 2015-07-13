<?

namespace MP\Lib;

class Krakow_radni_dzielnic_glosy extends DataObject
{
	
	protected $tiny_label = 'Uchwała';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'date' => 'krakow_dzielnice_uchwaly.data',
    );

	
	public function hasHighlights()
    {
        return false;
    }
    
    public function getUrl()
    {
	    return false;
    }
    
}