<?

namespace MP\Lib;

class Panstwa extends DataObject
{
	
	protected $tiny_label = 'Państwo';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Państwo';
    }
    
    public function hasHighlights()
    {
        return false;
    }

}