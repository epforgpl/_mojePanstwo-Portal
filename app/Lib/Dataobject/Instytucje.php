<?

namespace MP\Lib;

class Instytucje extends DataObject
{
	
	protected $tiny_label = 'Instytucja';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
	
    public function getLabel()
    {
        return 'Instytucja publiczna';
    }
	
	public function hasHighlights()
    {
        return false;
    }
    
    public function getThumbnailUrl($size = '2')
    {
		
        return $this->getData('avatar') ? 'https://mojepanstwo.pl/KtoTuRzadzi/img/instytucje/' . $this->getId() . '.png' : false;

    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		if( $this->getData('instytucje.budzet_plan') )
			$output[] = 'Budżet roczny: ' . number_format_h(1000 * $this->getData('instytucje.budzet_plan')) . ' PLN';
		
		return $output;
		
	}
    
}