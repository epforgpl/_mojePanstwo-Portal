<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Zamowienia_publiczne_dokumenty extends DocDataObject
{
	
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
	
	public function getShortTitle() {
		
		switch( $this->getData('typ_id') ) {
			case '1': return 'Ogłoszenie zamówienia';
			case '2': return 'Ogłoszenie zamówienia';
			case '3': return 'Udzielenie zamówienia';
			case '4': return 'Ogłoszenie konkursu';
			case '5': return 'Ogłoszenie wyników konkursu';
			case '6': return 'Zmiana zamówienia';
			case '7': return 'Zamiar zawarcia umowy';
			default: return 'Ogłoszenie';
		}
		
	}
	
    public function getLabel()
    {
		
		$status = $this->getStatus();		
		if( $this->getData('tryb_id')=='2' ) {
			
			return '<span class="label label-danger">Zamówienie z wolnej ręki</span>';
			
		} else {
		
        $output = $this->getData('zamowienia_publiczne_tryby.nazwa');
        if( $this->getData('status_id')=='2' )
        	
        	$output .= ' <span class="label label-danger">Rozstrzygnięto</span>';
        
        }
        return $output;

    }
    
    public function getStatus(){
	    
	    $nazwa = '';
	    
	    if( $this->getData('status_id')=='0' )
	    	return array(
	    		'nazwa' => 'Zamówienie otwarte',
	    		'class' => 'success',
	    	);

		elseif( $this->getData('status_id')=='2' )	
	    	return array(
	    		'nazwa' => 'Zamówienie rozstrzygnięte',
	    		'class' => 'danger'
	    	);
	    	
	    
	    return array(
	    	'nazwa' => '',
	    	'class' => '',
	    );
	    
    }
    
    public function getUrl() {
	    
	    $parent_id = $this->getId();
	    if(
		    $this->getData('child') &&
		    $this->getData('parent_id')
	    )
	    	$parent_id = $this->getData('parent_id');
	    	
	    return '/dane/zamowienia_publiczne/' . $parent_id . '/dokumenty/' . $this->getId();
	    
	}
    
    public $force_hl_fields = true;
    
    
    
}