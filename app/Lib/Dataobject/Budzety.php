<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Budzety extends DocDataObject
{
	
	protected $tiny_label = 'Budżet';
	
    protected $routes = array(
        'title' => 'prawo.tytul',
        'shortTitle' => 'prawo.tytul',
    );
	
	public function getShortTitle() {
		return 'Budżet centralny na rok ' . $this->getData('rok');
	}
	
	public function getTitle() {
		return $this->getShortTitle();
	}
	
    public function getLabel()
    {
        return 'Budżet';
    }
		
}