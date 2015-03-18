<?

namespace MP\Lib;

class Miejscowosci extends DataObject
{
	
	protected $tiny_label = 'Miejscowość';
	
	protected $schema = array(
		array('gminy.nazwa', 'Gmina', 'string', array(
			'link' => array(
				'dataset' => 'gminy',
				'object_id' => '$gminy.id',
			),
		)),
	);
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'label' => 'miejscowosci_typy.nazwa',
    );
    
    protected $hl_fields = array(
    	'gminy.nazwa'
    );
    
    public function hasHighlights()
    {
        return false;
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/' . $this->getData('gmina_id') . '/miejscowosci/' . $this->getId();
    }
    
    public $force_hl_fields = true;

}