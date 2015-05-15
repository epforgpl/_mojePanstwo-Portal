<?

namespace MP\Lib;

class Zbiory extends DataObject
{
	
	protected $tiny_label = 'Zbiór danych';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Zbiór danych';
    }
    
    public function hasHighlights()
    {
        return false;
    }

    public function getIcon()
    {
        return false;
    }
    
    public function getUrl()
    {
	    if( $this->getData('slug') == 'zbiory' )
	    	return '/dane';
	    else
		    return '/dane/' . $this->getData('slug');
    }

}