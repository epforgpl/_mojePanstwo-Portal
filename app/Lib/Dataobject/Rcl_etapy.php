<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Rcl_etapy extends DocDataObject
{
	
	protected $tiny_label = 'Etap w legislacji';
	
	protected $schema = array(
		array('tytul_projektu', 'Dotyczy projektu'),
	);
	
    protected $routes = array(
        'shortTitle' => 'rcl_etapy_typy.tytul',
        'date' => 'data',
    );

	public $hl_fields = array('tytul_projektu');
	
    public function getLabel()
    {
        return 'Etap w pracach legislacyjnych rządu';
    }

    public function getTitle()
    {
        return $this->getData('rcl_etapy_typy.tytul') . ' - ' . $this->getData('tytul_projektu');
    }

}