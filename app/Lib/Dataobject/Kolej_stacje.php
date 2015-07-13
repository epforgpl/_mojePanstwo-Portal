<?

namespace MP\Lib;

class Kolej_stacje extends DataObject
{
	
	protected $tiny_label = 'Stacja kolejowa';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Stacja kolejowa';
    }
	
	public function hasHighlights()
    {
        return false;
    }
}