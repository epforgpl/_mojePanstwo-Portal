<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_zamrazarka extends DocDataObject
{
	
	protected $schema = array(
		array('autorzy_str', 'Autor'),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
        'label' => 'label'
    );
    
    protected $hl_fields = array(
    	'autorzy_str'
    );

    public function getLabel()
    {
        return '<strong>Projekt</strong> w "zamrażarce Marszałka"';
    }
    
    public function getUrl()
    {
	    if( $this->getData('projekt_id') )
	    	return '/dane/prawo_projekty/' . $this->getData('projekt_id') . '/zamrazarka/' . $this->getId();
	    else
	    	return false;
    }

}