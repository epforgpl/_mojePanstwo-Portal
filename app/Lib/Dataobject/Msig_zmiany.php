<?

namespace MP\Lib;

class Msig_zmiany extends DataObject
{
	
	protected $tiny_label = 'Zmiana w KRS';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'label' => 'miejscowosci_typy.nazwa',
    );
    
    protected $hl_fields = array(
    );
    
    public function getUrl()
    {
	    // return '/dane/gminy/' . $this->getData('gmina_id') . '/miejscowosci/' . $this->getId();
    }
    
    public $force_hl_fields = true;

}