<?

namespace MP\Lib;

class Zamowienia_publiczne_zamawiajacy extends DataObject
{
	
	protected $tiny_label = 'Urzędnicy';
		
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Zamawiający';
    }
	
}