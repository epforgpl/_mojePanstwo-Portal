<?

namespace MP\Lib;

class Kultura_ankiety extends DataObject
{
		
    public $force_hl_fields = true;
    protected $routes = array(
        'title' => 'title',
        'shortTitle' => 'title',
    );

    public function getLabel()
    {
        return 'Badanie uczestnictwa w kulturze';
    }
	
	public function hasHighlights()
    {
        return false;
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		$output[] = $this->getData('file');				
        return $output;

    }

}