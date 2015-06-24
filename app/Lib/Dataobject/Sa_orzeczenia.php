<?

namespace MP\Lib;

class Sa_orzeczenia extends DataObject
{

    public $force_hl_fields = true;
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
	    return 'Orzeczenie ' . $this->getData('sad_dopelniacz');
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
						
		$output = array(
			dataSlownie($this->getDate()),
		);
		
		if( $this->getData('skarzony_organ_str') )
			$output[] = 'Skarżony organ: ' . $this->getData('skarzony_organ_str');
			
		$output[] = $this->getData('wynik_str');
		
		return $output;
		
	}

}