<?

namespace MP\Lib;

class Poslowie extends DataObject
{
	
    public $force_hl_fields = true;
	protected $tiny_label = 'Poseł';
	
    protected $schema = array(
		array('sejm_kluby.nazwa', '', 'string', array(
			'img' => 'http://resources.sejmometr.pl/s_kluby/{$klub_id}_a_t.png',
		)),
		array('zawod', 'Zawód', 'string', array(
			'normalizeText' => true,
		)),
		array('data_urodzenia', 'Wiek', 'date', array(
			'format' => 'wiek',
		)),
		array('liczba_wypowiedzi', 'Liczba wystąpień', 'integer'),
		array('liczba_przelotow', 'Liczba przelotów', 'integer'),
		array('liczba_przejazdow', 'Liczba przejazdów', 'integer'),
		array('wartosc_wyjazdow', 'Koszt wyjazdów zagranicznych', 'pln'),
		
		array('wartosc_biuro_wynagrodzenia_pracownikow', 'Wynagrodzenia pracowników', 'pln'),
		array('wartosc_biuro_zlecenia', 'Zlecenia i umowy o dzieło', 'pln'),
		array('wartosc_biuro_ekspertyzy', 'Ekspertyzy, opinie, tłumaczenia', 'pln'),
		array('wartosc_biuro_telekomunikacja', 'Usługi telekomunikacyjne', 'pln'),
		array('wartosc_biuro_spotkania', 'Wynajmowanie sal na spotkania z wyborcami', 'pln'),
		array('wartosc_biuro_przejazdy', 'Przejazdy samochodem', 'pln'),
		array('wartosc_biuro_taksowki', 'Przejazdy taksówkami', 'pln'),
		array('wartosc_biuro_biuro', 'Wynajęcie i utrzymanie biura', 'pln'),
		array('wartosc_biuro_materialy_biurowe', 'Materiały biurowe, prasa, środki BHP', 'pln'),
		array('wartosc_biuro_srodki_trwale', 'Wyposażenie biura (środki trwałe)', 'pln'),
		array('wartosc_biuro_podroze_pracownikow', 'Podróże pracowników', 'pln'),
		array('wartosc_biuro_inne', 'Inne', 'pln'),
	);
    
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
    
    protected $hl_fields = array(
    	'sejm_kluby.nazwa', 'zawod', 'data_urodzenia'
    );
	
	public function __construct($params = array())
    {
    	parent::__construct($params);
    	
    	if( $this->data('klub_id')=='7' )    	
	    	unset( $this->schema[0][3]['img'] );
	    	
    }
	
    public function getLabel()
    {
        return 'Poseł na Sejm RP';
    }

    public function getThumbnailUrl($size = '0')
    {
        return 'http://resources.sejmometr.pl/mowcy/a/' . $size . '/' . $this->getData('ludzie.id') . '.jpg';
    }
    
    public function getHeaderThumbnailUrl($size = '0')
    {
        return 'http://resources.sejmometr.pl/mowcy/a/' . $size . '/' . $this->getData('ludzie.id') . '.jpg';
    }
    
    public function hasHighlights()
    {
        return false;
    }
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $this->getData('poslowie.data_urodzenia') )
			$output[] = pl_wiek($this->getData('poslowie.data_urodzenia')) . ' l.';
			
		if( $this->getData('sejm_kluby.skrot') )
			$output[] = $this->getData('sejm_kluby.nazwa');
			
		if( $this->getData('poslowie.zawod') )
			$output[] = $this->getData('poslowie.zawod');
		
		return $output;
		
	}

}