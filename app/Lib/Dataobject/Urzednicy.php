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
		
		$output = array(
			$this->getData('stanowisko'),
		);
				
		return $output;
		
	}
	
}