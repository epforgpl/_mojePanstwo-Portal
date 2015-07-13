<?

namespace MP\Lib;

class Krakow_urzednicy extends DataObject
{
	
	protected $tiny_label = 'Urzędnik';
	
	protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
	
    public function getLabel()
    {
        return '<strong>Urzędnik</strong> miasta Kraków';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/urzednicy/' . $this->getId();
    }
    
    public function getBreadcrumbs()
	{
				
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/urzednicy',
				'label' => 'Urzędnicy Urzędu Miasta',
			),
		);
				
	}

}