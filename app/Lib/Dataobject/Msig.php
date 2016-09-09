<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Msig extends DataObject
{
	
	protected $tiny_label = 'MSiG';
	
    protected $routes = array(
        'date' => 'data',
    );

    public function getLabel()
    {
        return 'Monitor Sądowy i Gospodarczy';
    }

    public function getShortTitle()
    {
        return $this->getData('nr') . ' / ' . $this->getData('rocznik');
    }

    public function getTitle()
    {
        return $this->getLabel() . ' ' . $this->getShortTitle();
    }
    
    public function getFullLabel()
    {
        return 'Monitor Sądowy i Gospodarczy z dnia ' . dataSlownie( $this->getDate() );
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array(
			dataSlownie($this->getDate()),
		);
				
		return $output;
		
	}
	
	public function getPageDescription()
	{
		return dataSlownie($this->getDate(), array(
	        'relative' => false,
        ));
	}

}