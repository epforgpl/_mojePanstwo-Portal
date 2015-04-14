<?

namespace MP\Lib;

class Sejm_glosowania extends DataObject
{
	
	protected $tiny_label = 'Głosowanie';
	
	protected $schema = array(
		array('sejm_posiedzenia.tytul', 'Numer posiedzenia', 'string', array(
			'link' => array(
				'dataset' => 'sejm_posiedzenia',
				'object_id' => '$sejm_posiedzenia.id',
			),
		)),
		array('numer', 'Numer głosowania'),
		array('wynik_id', 'Wynik', 'vote'),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'czas',
        'time' => 'czas',
    );
    
    protected $hl_fields = array(
    	'wynik_id',
    );
    
    public function getLabel()
    {
        return 'Głosowanie w Sejmie';
    }
    
    public function getPosition() {
	    // return '#' . $this->getData('numer');
	    return false;
    }
    
    public function getUrl() {
	    
	    $output = '/dane';
	    
	    if( $this->getData('punkt_id') ) {
		    
	    	$output .= '/sejm_posiedzenia_punkty/' . $this->getData('punkt_id');
	    	
	    	if( $this->getData('debata_id') ) {
		    
		    	$output .= '/debaty/' . $this->getData('debata_id');
		    	
		    }
	    	
	    } elseif( $this->getData('debata_id') ) {
		    
	    	$output .= '/sejm_debaty/' . $this->getData('debata_id');
	    		    
	    }
	    
	    $output .= '/glosowania/' . $this->getId();
	    
	    return $output;
	    
    }

}