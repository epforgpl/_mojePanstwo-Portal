<?

namespace MP\Lib;

class Handel_zagraniczny_towary extends DataObject
{
	
	protected $tiny_label = 'Towar';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Towar';
    }
    
    public function hasHighlights()
    {
        return false;
    }

}