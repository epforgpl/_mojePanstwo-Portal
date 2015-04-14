<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_zarzadzenia extends DocDataObject
{
	
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data_podpisania',
    );
		
    public function getShortLabel()
    {
        return 'Zarządzenie Prezydenta Krakowa';
    }
    
    public function getLabel()
    {
        return 'Zarządzenie Prezydenta Krakowa';
    }
    
    public function getTitle()
    {
        return 'Zarządzenie Prezydenta Krakowa ' . $this->getData('tytul');
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903,Krakow/zarzadzenia/' . $this->getId();
    }
    
    public $force_hl_fields = true;

}