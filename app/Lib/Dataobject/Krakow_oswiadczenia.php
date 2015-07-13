<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_oswiadczenia extends DocDataObject
{
	
	protected $tiny_label = 'Oświadczenie majątkowe';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
        'description' => 'krakow_jednostki.nazwa',
    );
	
    public function getLabel()
    {
        return 'Oświadczenia majątkowe';
    }
    
    public function getShortTitle()
    {
	    return $this->getData('krakow_urzednicy.nazwa') . ' (' . $this->getData('rok') . ')';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/oswiadczenia/' . $this->getId();
    }
    
    public function getBreadcrumbs()
	{
							
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/urzednicy',
				'label' => 'Urzędnicy Urzędu Miasta',
			),
			array(
				'id' => '/dane/gminy/903,krakow/urzednicy/' . $this->getData('krakow_urzednicy.id'),
				'label' => $this->getData('krakow_urzednicy.nazwa'),
			),
		);
				
	}

}