<?

namespace MP\Lib;

class Poslowie_biura_wydatki extends DataObject
{
	
	public function __construct($params = array())
    {

        parent::__construct($params);
		
		$this->data['poslowie.nazwa_klub'] = $this->data['poslowie.nazwa'] . ' <br/><small><b>' . $this->data['sejm_kluby.skrot'] . '</b></small>';
		

    }
	
    public function getLabel()
    {
        return 'Wydatki biur poselskich w 2013 r.';
    }
    
	protected $routes = array(
        'shortTitle' => 'poslowie_biura_wydatki.nazwa',
        'title' => 'poslowie_biura_wydatki.nazwa',
    );
    
    protected $schema = array(
		array('poslowie_biura_wydatki.wartosc_koszt', 'Koszt', 'pln'),
		array('poslowie_biura_wydatki.wartosc_koszt_posel', 'Średnio na posła', 'pln'),
		array('poslowie_biura_wydatki.wartosc_koszt_posel_max', 'Najwięcej na posła', 'pln'),
		array('poslowie.nazwa_klub', '', 'string', array(
			'link' => array(
				'dataset' => 'poslowie',
				'object_id' => '$poslowie.id',
			),
			'img' => 'http://resources.sejmometr.pl/mowcy/a/3/{$ludzie_poslowie.mowca_id}.jpg'
		)),
	);
    
    public $hl_fields = array(
		'poslowie_biura_wydatki.wartosc_koszt', 'poslowie_biura_wydatki.wartosc_koszt_posel', 'poslowie_biura_wydatki.wartosc_koszt_posel_max', 'poslowie.nazwa_klub'
	);
	
	public function getUrl() {
		return false;
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $this->getData('poslowie_biura_wydatki.wartosc_koszt') )
			$output[] = 'Suma wydatków: ' . number_format_h( $this->getData('poslowie_biura_wydatki.wartosc_koszt') ) . ' PLN';
		
		return $output;
		
	}

}