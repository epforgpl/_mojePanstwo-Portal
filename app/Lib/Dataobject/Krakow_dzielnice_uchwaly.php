<?

namespace MP\Lib;

class Krakow_dzielnice_uchwaly extends DataObject
{
	
	protected $tiny_label = 'Uchwała';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'date' => 'data_wydania',
    );

    public function getLabel()
    {
        return 'Uchwała rady dzielnicy ' . $this->getData('dzielnice.nazwa');
    }
    
    public function getShortLabel()
    {
        return 'Uchwała rady dzielnicy ' . $this->getData('dzielnice.nazwa');
    }
	
	public function hasHighlights()
    {
        return false;
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/dzielnice/' . $this->getData('dzielnica_id') . '/rada_uchwaly/' . $this->getId();
    }
    
    public $force_hl_fields = true;

}