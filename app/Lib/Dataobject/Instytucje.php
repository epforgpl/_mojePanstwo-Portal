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
}