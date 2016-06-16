<?

namespace MP\Lib;

class Aplikacje extends DataObject
{
	
	protected $tiny_label = 'Aplikacja';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Aplikacja';
    }
    
    public function hasHighlights()
    {
        return false;
    }
    
    public function getUrl()
    {
	    return '/' . $this->getData('slug');
    }

}