<?

namespace MP\Lib;

class Zamowienia_publiczne extends DataObject
{

    public $force_hl_fields = true;
	protected $tiny_label = 'Zamówienie publiczne';
	protected $schema = array(

		array('zamowienia_publiczne_tryby.nazwa', false),
		array('zamawiajacy_nazwa', 'Zamawiający'),
		array('zamawiajacy_miejscowosc', 'Miejscowość'),
		array('data_publikacji', 'Data publikacji', 'date'),
		/*
		array('status_id', 'Status', 'text', array(
			'dictionary' => array(
				'0' => 'Aktywne',
				'2' => 'Rozstrzygnięte'
			)
		)),
		array('tryb_id', 'Tryb', 'text'),
		array('rodzaj_id', 'Rodzaj', 'text'),
		*/

	);
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'date' => 'data_publikacji',
    );
	protected $hl_fields = array(
    	'zamawiajacy_nazwa', 'zamawiajacy_miejscowosc',
    );

    public function getLabel()
    {
        $status = $this->getStatus();

		if( $this->getData('tryb_id')=='2' ) {
			$output = 'Zamówienie z wolnej ręki';
		} else {
	        $output = $this->getData('zamowienia_publiczne_tryby.nazwa');
        }

		$output .= ' z ' . dataSlownie( $this->getDate() );

        return $output;
    }

    public function getStatus(){
	    $nazwa = '';

        if( $this->getData('status_id')=='0' )
	    	return array(
	    		'nazwa' => 'Zamówienie otwarte',
	    		'class' => 'success',
	    	);

        elseif ($this->getData('status_id') == '2')
	    	return array(
	    		'nazwa' => 'Zamówienie rozstrzygnięte',
	    		'class' => 'danger'
	    	);


        return array(
	    	'nazwa' => '',
	    	'class' => '',
	    );

    }

    public function getMetaDescriptionParts($preset = false)
	{

        $output = array();
		
		if( $this->getData('status_id')=='0' )
			$output[] = '<span class="label label-success">Zamówienie otwarte</span>';
		elseif( $this->getData('status_id')=='2' )
			$output[] = '<span class="label label-danger">Zamówienie rozstrzygnięte</span>';
				
		if( $this->getData('zamowienia_publiczne.zamawiajacy_nazwa') )
			$output[] = 'Zamawiający: ' . $this->getData('zamowienia_publiczne.zamawiajacy_nazwa');
		
        if( $this->getData('zamowienia_publiczne.wartosc_cena') )
			$output[] = 'Wartość: ' . number_format_h($this->getData('zamowienia_publiczne.wartosc_cena')) . ' PLN';

        return $output;

    }
    
    public function getDescription()
    {
	    return $this->getData('przedmiot');
    }
    
    public function getPageDescription()
    {
	    return false;
    }

}