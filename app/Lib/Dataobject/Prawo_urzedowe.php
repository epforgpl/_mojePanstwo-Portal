<?

namespace MP\Lib;

class Prawo_urzedowe extends DocDataObject
{
	
	protected $schema = array(
		array('instytucje.nazwa', 'Autor', 'string'),
	);
    
    protected $hl_fields = array(
    	'instytucje.nazwa',
    );
	
	protected $tiny_label = 'Patent';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul_skrocony',
        'date' => 'data_wydania',
        'label' => 'forma_str',
    );
    
    public $force_hl_fields = true;

}