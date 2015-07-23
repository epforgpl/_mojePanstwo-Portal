<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_druki extends DocDataObject
{

    public $force_hl_fields = true;
	protected $tiny_label = 'Druk sejmowy';
	protected $schema = array(
		array('druk_typ_nazwa', 'Typ druku'),
		array('numer', 'Numer druku')
	);
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
        'label' => 'label'
    );
    protected $hl_fields = array(
    	'druk_typ_nazwa'
    );

    public function getLabel()
    {
        return 'Druk sejmowy <strong>nr ' . $this->getData('numer') . '</strong>';
    }

    public function getFullLabel()
    {
        return 'Druk sejmowy nr ' . $this->getData('numer') . ' z dnia' . dataSlownie( $this->getDate() );
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
		return array(
			dataSlownie($this->getDate()),
			$this->getData('sejm_druki.autorzy_str'),
		);
		
	}
	
	public function getUrl() {
		
		return '/dane/instytucje/3214/druki/' . $this->getId() . ',' . $this->getSlug();
		
	}
	
	public function getBreadcrumbs()
	{
							
		return array(
			array(
				'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/druki',
				'label' => 'Druki sejmowe',
			),
		);
				
	}

}