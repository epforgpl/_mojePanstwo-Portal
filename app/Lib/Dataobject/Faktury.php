<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Faktury extends DocDataObject
{
	
	protected $tiny_label = 'Faktura';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Umowa';
    }
	
	public function getUrl()
	{
		return '/dane/krs_podmioty/' . $this->getData('krs_id') . '/faktury/' . $this->getId();
	}
		
}