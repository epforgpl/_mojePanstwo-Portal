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
        switch( $this->getData('typ_id') ) {
	        case '1': return 'Projekt ustawy';
	        case '2': return 'Projekt uchwały';
	        case '5': return 'Powołanie / odwołanie';
	        case '6': return 'Umowa międzynarodowa';
	        case '11': return 'Sprawozdanie kontrolne';
	        case '12': return 'Projekt';
	        case '100': return 'Zmiana w składach komisji';
	        case '103': return 'Wniosek o referendum';
        }
    }
    
    public $force_hl_fields = true;

}