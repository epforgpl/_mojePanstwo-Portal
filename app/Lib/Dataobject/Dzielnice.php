<?

namespace MP\Lib;

class Dzielnice extends DataObject
{
	
	protected $tiny_label = 'Dzielnica';
	
	protected $schema = array(
		array('gminy.nazwa', 'Gmina', 'string', array(
			'link' => array(
				'dataset' => 'gminy',
				'object_id' => '$gminy.id',
			),
		)),
	);
    
    protected $hl_fields = array(
    	'gminy.nazwa'
    );
    
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );	
		
	public function hasHighlights()
    {
        return false;
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/' . $this->getData('gminy.id') . '/dzielnice/' . $this->getId();
    }
    
    public function getLabel()
    {
	    return 'Dzielnica Miasta ' . $this->getData('gminy.nazwa');
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array(
			'Dzielnica miasta Kraków'
		);
		
		return $output;
		
	}
    
}