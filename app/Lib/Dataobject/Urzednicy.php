<?

namespace MP\Lib;

class Urzednicy extends DataObject
{
	
	protected $tiny_label = 'Urzędnicy';
	
	protected $schema = array(	
		array('stanowisko', 'Stanowisko'),
	);
	
	protected $hl_fields = array(
    	'stanowisko',
    );
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Urzędnik';
    }

    public function hasHighlights()
    {
        return false;
    }
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $this->getData('stanowisko_aktywne') )
			$output[] = 'Aktualnie urzędujący';
		else
			$output[] = 'Urzędujący w przeszłości';
		
		$output[] = $this->getData('stanowisko');
				
		return $output;
		
	}
	
	public function getUrl()
	{
		return '/dane/instytucje/' . $this->getData('instytucja_id') . '/urzednicy/' . $this->getId() . ',' . $this->getSlug();
	}
	
}