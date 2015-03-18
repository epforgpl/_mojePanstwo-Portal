<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Prawo_lokalne extends DocDataObject
{
	
	protected $tiny_label = 'Akt prawny';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul_skrocony',
        'date' => 'data_wydania',
        'label' => 'label',
        'description' => 'opis',
    );

    public function getLabel()
    {
        return 'Uchwała <strong>' . $this->getData('jednostka_dopelniacz') . '</strong>, numer <strong>' . $this->getData('akt_numer') . '</strong> z dnia <strong>' . $this->dataSlownie($this->getDate()) . '</strong>';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/' . $this->getData('gmina_id') . '/rada_uchwaly/' . $this->getId();
    }
	
	public $force_hl_fields = true;
	
}