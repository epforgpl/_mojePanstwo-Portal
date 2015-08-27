<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Prawo_urzedowe extends DocDataObject
{

    public $force_hl_fields = true;
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

    public function getLabel()
    {
        return $this->getData('prawo_urzedowe.forma_str') . ' z dnia ' . dataSlownie($this->getDate());
    }
    
    public function getUrl()
    {
	    return '/dane/instytucje/' . $this->getData('instytucja_id') . '/dziennik/' . $this->getId();	    
    }
}