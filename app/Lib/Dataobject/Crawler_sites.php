<?

namespace MP\Lib;

class Crawler_sites extends DataObject
{
	
	protected $tiny_label = 'Portal';
	
	protected $schema = array(
		array('url', 'URL'),
		array('liczba_dokumentow', 'Strony'),
		array('liczba_linkow', 'Linki'),
	);
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'date' => false,
    );
    
    protected $hl_fields = array(
    );
    
    public function getLabel()
    {
	    return 'Portal';
    }

}