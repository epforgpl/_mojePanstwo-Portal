<?

namespace MP\Lib;

class Budzet_wydatki_czesci extends DataObject
{
	
	protected $tiny_label = 'Budżet';
	
	protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
	
    public function getLabel()
    {
        return 'Część budżetu narodowego';
    }
    
    public function getPosition()
    {
	    return $this->getData('src');
    }

}