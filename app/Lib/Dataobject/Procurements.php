<?

namespace MP\Lib;

class Procurements extends DataObject
{

    public $force_hl_fields = true;
	protected $tiny_label = 'Zamówienie publiczne';
	protected $schema = array(

		array('zamowienia_publiczne_tryby.nazwa', false),
		array('purchaser_name', 'Zamawiający'),
		array('purchaser_city', 'Miejscowość'),
		array('publication_date', 'Data publikacji', 'date'),
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
        'title' => 'name',
        'shortTitle' => 'name',
        'date' => 'publication_date',
    );
	protected $hl_fields = array(
    	'purchaser_name', 'purchaser_city',
    );

    public function getLabel()
    {
        $status = $this->getStatus();

		/*
		if( $this->getData('tryb_id')=='2' ) {
			$output = 'Zamówienie z wolnej ręki';
		} else {
	        $output = $this->getData('zamowienia_publiczne_tryby.nazwa');
        }
        */

		$output = 'Zamówienie publiczne z ' . dataSlownie( $this->getDate() );

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
				
		if( $this->getData('purchaser_name') )
			$output[] = 'Zamawiający: ' . $this->getData('purchaser_name');
		
        if( $this->getData('value_ammount') )
			$output[] = 'Wartość: ' . number_format_h($this->getData('value_ammount')) . ' PLN';

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