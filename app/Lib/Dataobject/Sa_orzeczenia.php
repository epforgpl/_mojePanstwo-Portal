<?

namespace MP\Lib;

class Sa_orzeczenia extends DataObject
{
	
	protected $tiny_label = 'Orzeczenie sądu';
	
	protected $schema = array(
		array('skarzony_organ_str', 'Skarżony organ'),
		array('wynik_str', 'Wynik'),
		array('dlugosc_rozpatrywania', 'Długość postępowania', 'integer', array(
			'dopelniacz' => array('dzień', 'dni', 'dni'),
		)),
	);
	
    protected $routes = array(
        'title' => 'sygnatura',
        'shortTitle' => 'sygnatura',
        'date' => 'data_orzeczenia',
    );
	
	protected $hl_fields = array(
    	'skarzony_organ_str', 'wynik_str'
    );
    
    public function getLabel() {
	    return 'Orzeczenie z dnia ' . dataSlownie( $this->getDate() );
    }
    
    public $force_hl_fields = true;

}