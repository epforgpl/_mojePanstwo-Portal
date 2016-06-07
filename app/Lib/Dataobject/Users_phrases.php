<?

namespace MP\Lib;

class Users_phrases extends DataObject
{
	
    public $force_hl_fields = true;
	protected $tiny_label = 'Fraza';
	
    protected $routes = array(
        'title' => 'q',
        'shortTitle' => 'q',
    );

    public function getLabel()
    {
        return 'Fraza';
    }
    
    public function hasHighlights()
    {
        return false;
    }
    
    public function getUrl()
    {
	    return '/?q=' . urlencode( $this->getData('q') );
    }

}