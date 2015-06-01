<?

namespace MP\Lib;

class Krs_podmioty extends DataObject
{

    public $force_hl_fields = false;
	protected $tiny_label = 'Organizacja';
	protected $schema = array(
		array('id', 'ID'),
		array('krs', 'KRS'),
		array('nip', 'NIP'),
		array('regon', 'REGON'),
		array('data_rejestracji', 'Data rejestracji'),
		array('data_dokonania_wpisu', 'Data dokonania wpisu'),
		array('nazwa', 'Nazwa'),
		array('adres_miejscowosc', 'Miejscowość'),
		array('forma_prawna_str', 'Forma prawna'),
		array('email', 'Email'),
		array('www', 'WWW'),

		/*
		array('wartosc_kapital_zakladowy', 'Kapitał zakładowy', 'pln'),
		array('wartosc_czesc_kapitalu_wplaconego', 'Cześć kapitału wpłaconego', 'pln'),
		array('wartosc_kapital_docelowy', 'Kapitał docelowy', 'pln'),
		array('wartosc_nominalna_akcji', 'Wartość nominalna akcji', 'pln'),
		array('wartosc_nominalna_podwyzszenia_kapitalu', 'Wartość nominalna podwyższenia kapitału', 'pln'),
		*/

        array('oznaczenie_sadu', 'Sąd', 'string', array(
			'truncate' => 30,
		)),
		array('sygnatura_akt', 'Sygnatura akt'),
		array('wczesniejsza_rejestracja_str', 'Wcześniejsza rejestracja'),
	);
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa_skrocona',
        'date' => false,
    );
    protected $hl_fields = array(
    	'krs', 'adres_miejscowosc', 'data_rejestracji', 'wartosc_kapital_zakladowy'
    );
    
 	public function __construct($params = array())
    {

        parent::__construct($params);

        if( !$this->getData('nazwa') )
			$this->data['nazwa'] = $this->data['firma'];

        if( !$this->getData('nazwa_skrocona') )
			$this->data['nazwa_skrocona'] = $this->data['firma'];

        if( !empty($this->data) )
	        foreach( $this->data as $key => &$val )
		        if( !trim(str_replace('-', '', $val)) )
		        	$val = false;

    }

    public function getIcon()
    {
        return '<i class="object-icon glyphicon" data-icon-datasets="&#xe63a;"></i>';
    }
 	
    public function getLabel()
    {
        return 'Organizacja';
    }
    
    public function hasHighlights()
    {
        return false;
    }
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array(
			$this->getData('forma_prawna_str'),
			$this->getData('adres_miejscowosc'),
		);
		
		if( $this->getData('wartosc_kapital_zakladowy') )
			$output[] = number_format_h($this->getData('wartosc_kapital_zakladowy')) . ' PLN';
		
		return $output;
		
	}
	
	public function getDescription() {
		
		if( $this->getData('cel_dzialania') )
			return substr($this->getData('cel_dzialania'), 0, 100) . '...';
		else
			return false;
		
	}
	
}