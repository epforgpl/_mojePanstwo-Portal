<?

namespace MP\Lib;

class Krakow_glosowania extends DataObject
{
	
	protected $tiny_label = 'Głosowanie';
	
	protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
    );
	
    public function getLabel()
    {
        return '<strong>Głosowanie</strong> Rady Miasta Kraków';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/glosowania/' . $this->getId();
    }
    
    public function getShortLabel()
    {
        return 'Głosowanie Rady Miasta Kraków';
    }
    
	public function getDescription() {
		return $this->getData('wynik_str');	
	}
}