<?

namespace MP\Lib;
require_once( 'DocDataObject.php' );

class Prawo_urzedowe extends DocDataObject
{
	
	protected $schema = array(
		array('instytucje.nazwa', 'Autor', 'string'),
	);
    
    protected $hl_fields = array(
    	'instytucje.nazwa',
    );
	
	protected $tiny_label = 'Patent';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul_skrocony',
        'date' => 'data_wydania',
        'label' => 'forma_str',
    );
    
    public $force_hl_fields = true;
	
	public function getLabel() {
		return $this->getData('prawo_urzedowe.forma_str') . ' z dnia ' . dataSlownie( $this->getDate() );
	}
	
}