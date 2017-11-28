<?

namespace MP\Lib;

class Krakow_praca extends DataObject
{
	
	protected $tiny_label = 'Samorząd';
	
	protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
    );
	
    public function getLabel()
    {
        return '<strong>Ogłoszenie</strong> o pracę';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903/praca/' . $this->getId();
    }
    
    public function getShortLabel()
    {
        return 'Ogłoszenie o pracę';
    }
    
    public function getBreadcrumbs()
	{
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/praca',
				'label' => 'Ogłoszenia o pracę',
			),
		);
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
		$output = [];
		
		if( $this->getData('aktywne') ) {
			$output[] = 'Nabór trwa';
		} {
			$output[] = 'Nabór zakończony';
		}
		
        if( $this->getData('wiecej') )
			$output[] = $this->getData('wiecej');
			
		if( $this->getData('opis') )
			$output[] = $this->getData('opis');

        return $output;

    }
    
    public function getDescription()
    {
	    return false;
    }

}