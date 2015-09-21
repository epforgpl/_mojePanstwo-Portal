<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Faktury extends DocDataObject
{
	
	protected $tiny_label = 'Faktura';
    public $force_hl_fields = true;
    
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Faktura z ' . dataSlownie( $this->getDate() );
    }
	
	public function getUrl()
	{
		return '/dane/krs_podmioty/' . $this->getData('krs_id') . '/faktury/' . $this->getId();
	}
	
	public function getBreadcrumbs()
	{
				
		return array(
			array(
				'label' => $this->getLabel(),
			),
		);
				
	}
	
	public function getThumbnailUrl($size = false) {
		
		return 'http://docs.sejmometr.pl/thumb/5/' . $this->getData('dokument_id') . '.png';
		
	}
	
}