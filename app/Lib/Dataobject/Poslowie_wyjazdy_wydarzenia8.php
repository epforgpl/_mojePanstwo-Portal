<?

namespace MP\Lib;

class Poslowie_wyjazdy_wydarzenia8 extends DataObject
{
	
	
	protected $schema = array(
		array('wartosc_koszt', 'Koszt wyjazdu', 'pln'),
	);
	
    protected $routes = array(
        'date' => 'data_start',
        'shortTitle' => 'nazwa',
        'title' => 'nazwa',
    );
    
    public $hl_fields = array(
		'lokalizacja', 'wartosc_koszt'
	);

    public function getLabel()
    {
        return 'Wydarzenie zagraniczne';
    }
    
}