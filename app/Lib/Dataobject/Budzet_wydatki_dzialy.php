<?

namespace MP\Lib;

class Budzet_wydatki_dzialy extends DataObject
{
	
	protected $tiny_label = 'Budżet';
	
	protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
	
    public function getLabel()
    {
        return 'Dział budżetu narodowego';
    }
    
    public function getPosition()
    {
	    return $this->getData('src');
    }

}