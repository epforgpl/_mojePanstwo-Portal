<?

namespace MP\Lib;

class Wojewodztwa extends DataObject
{
	
	protected $tiny_label = 'Województwa';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Województwo';
    }
    
    public function hasHighlights()
    {
        return false;
    }

}