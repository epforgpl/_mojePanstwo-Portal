<?

namespace MP\Lib;

class Kolej_linie extends DataObject
{
	
	protected $tiny_label = 'Linia kolejowa';
	
	protected $schema = array(
		array('trasa_opis', 'Trasa'),
		array('liczba_stacji', 'Liczba stacji przestankowych', 'integer'),
		array('duration', 'Czas pełnego kursu', 'duration')
	);
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
    
    protected $hl_fields =array(
    	'trasa_opis', 'liczba_stacji', 'duration'
    );
		
    public function getLabel()
    {
        return 'Linia kolejowa';
    }
    
    public function getData($field = '*')
    {
    	if( $field=='trasa_opis' )	
    	{    
    		$val = str_replace('href="', 'href="/dane', $this->data['trasa_opis']);
	    	return $val;
	    }
	    	
    	return parent::getData( $field );        
    }

}