<?

namespace MP\Lib;

class Krakow_komisje extends DataObject
{
	
	protected $tiny_label = 'Samorząd';
	
	protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
	
    public function getLabel()
    {
        return '<strong>Komisja</strong> Rady Miasta Kraków';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903/komisje/' . $this->getId();
    }
    
    public function getShortLabel()
    {
        return 'Komisja Rady Miasta Kraków';
    }
    
    public function getBreadcrumbs()
	{
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/komisje',
				'label' => 'Komisje Rady Miasta',
			),
		);
	}

}