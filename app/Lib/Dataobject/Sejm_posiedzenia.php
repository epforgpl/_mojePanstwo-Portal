<?

namespace MP\Lib;

class Sejm_posiedzenia extends DataObject
{
	
	protected $tiny_label = 'Sejm';
	
    protected $routes = array(
        'shortTitle' => 'numer',
        'date' => 'data_start',
        'label' => 'label'
    );
	
	protected $schema = array(
		array('data_start', ''),
	);

	
    public function getLabel()
    {
        return 'Posiedzenie Sejmu';
    }

    public function getTitle()
    {
	    	    
    	if( $this->getData('numer') )
	        return 'Posiedzenie Sejmu nr ' . $this->getData('numer');
	    else
	    	return str_replace('Posiedzenie Sejmu nr ', '', $this->getData('tytul'));
    }
    
    public function getShortTitle()
    {
        return $this->getTitle();
    }
    
    public function hasHighlights()
    {
        return false;
    }

}