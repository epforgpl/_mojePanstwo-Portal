<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Senat_druki extends DocDataObject
{
	
	protected $tiny_label = 'Druk senacki';
	
	protected $schema = array(
		array('numer', 'Numer'),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
    );
    
    protected $hl_fields = array();
    
    public function getLabel()
    {
        return 'Druk senacki <strong>nr ' . $this->getData('numer') . '</strong>';
    }
    
    public function getFullLabel()
    {
        return 'Druk senacki nr ' . $this->getData('numer') . ' z dnia' . dataSlownie( $this->getDate() );
    }
    
    public $force_hl_fields = true;
    
    public function getMetaDescriptionParts($preset = false)
	{
		
		return array(
			dataSlownie($this->getDate())
		);
		
	}

}