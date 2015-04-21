<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Prawo_projekty extends DocDataObject
{
	
	protected $tiny_label = 'Projekt aktu prawnego';
	
	protected $schema = array(
		array('autorzy_html', ''),
		array('opis', 'Opis', 'string', array(
			'truncate' => 120,
		)),
		array('status_str', 'Status'),
		array('data', 'Data', 'date')
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul_skrocony',
        'date' => 'data_start',
        'label' => 'label',
        'description' => 'opis',
    );
    
    protected $hl_fields = array(
    	'autorzy_html', 'status_str'
    );

    public function getLabel()
    {
	    $output = '';
	    
        switch( $this->getData('typ_id') ) {
	        case '1': { $output = 'Projekt ustawy'; break; }
	        case '2': { $output = 'Projekt uchwały'; break; }
	        case '5': { $output = 'Powołanie / odwołanie'; break; }
	        case '6': { $output = 'Umowa międzynarodowa'; break; }
	        case '11': { $output = 'Sprawozdanie kontrolne'; break; }
	        case '12': { $output = 'Projekt'; break; }
	        case '100': { $output = 'Zmiana w składach komisji'; break; }
	        case '103': { $output = 'Wniosek o referendum'; break; }
        }
        
        $output .= ' z dnia ' . dataSlownie( $this->getDate() ); 
        
        return $output;
       
    }
    
    public $force_hl_fields = true;

}