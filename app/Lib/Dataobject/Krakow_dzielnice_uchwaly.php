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
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array(
			dataSlownie($this->getDate()),
		);
		
		return $output;
		
	}
	
	public function getBreadcrumbs()
	{
				
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/dzielnice/' . $this->getData('dzielnice.id'),
				'label' => $this->getData('dzielnice.nazwa'),
			),
			array(
				'id' => '/dane/gminy/903,krakow/dzielnice/' . $this->getData('dzielnice.id') . '/rada_uchwaly',
				'label' => 'Uchwały Rady Dzielnicy',
			),
		);
				
	}
    
    public $force_hl_fields = true;

}