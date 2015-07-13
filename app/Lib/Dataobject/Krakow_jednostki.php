<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_jednostki extends DataObject
{
	
	protected $tiny_label = 'Instytucja';
	
	protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
	
    public function getLabel()
    {
        return '<strong>Jednostka</strong> urzędu miasta Kraków';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/jednostki/' . $this->getId();
    }
    
    public function getBreadcrumbs()
	{
				
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/jednostki',
				'label' => 'Jednostki organizacyjne Urzędu Miasta',
			),
		);
				
	}

}