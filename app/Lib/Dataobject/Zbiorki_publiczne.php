<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Zbiorki_publiczne extends DocDataObject
{
	
	protected $tiny_label = 'Budżet';
	
    protected $routes = array(
        'title' => 'prawo.tytul',
        'shortTitle' => 'prawo.tytul',
    );
	
	public function getShortTitle() {
		return $this->getData('nazwa_zbiorki');
	}
	
	public function getTitle() {
		return $this->getShortTitle();
	}
	
    public function getLabel()
    {
        return 'Budżet';
    }
		
}