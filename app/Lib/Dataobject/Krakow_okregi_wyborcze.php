<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_okregi_wyborcze extends DocDataObject
{
	
	protected $tiny_label = 'Okręg wyborczy';

    public function getLabel()
    {
        return 'Darczyńca';
    }
	
	public function getUrl()
	{
		return false;
	}
	
	public function getTitle()
	{
		return $this->getShortTitle();
	}
	
	public function getShortTitle()
	{
		return 'Okręg wyborczy nr ' . $this->getData('numer');
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
				
		if( $this->getData('dzielnice_str') )
			$output[] = 'Dzielnice: ' . $this->getData('dzielnice_str');
														
		return $output;
		
	}
	
	public function getBreadcrumbs()
	{
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/okregi',
				'label' => 'Okręgi wyborcze',
			),
		);
	}
		
}