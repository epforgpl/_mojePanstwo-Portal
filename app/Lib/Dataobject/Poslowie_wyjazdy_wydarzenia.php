<?

namespace MP\Lib;

class Poslowie_wyjazdy_wydarzenia extends DataObject
{
	
	
	protected $schema = array(
		array('lokalizacja', '', 'string'),
		array('wartosc_koszt', 'Koszt wyjazdu', 'pln'),
	);
	
    protected $routes = array(
        'date' => 'data_start',
        'shortTitle' => 'delegacja',
        'title' => 'delegacja',
    );
    
    public $hl_fields = array(
		'lokalizacja', 'wartosc_koszt'
	);

    public function getLabel()
    {
        return 'Wydarzenie zagraniczne';
    }
    
}