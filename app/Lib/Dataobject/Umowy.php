<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Umowy extends DocDataObject
{
	
	protected $tiny_label = 'Umowa';
	
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
		return '/dane/krs_podmioty/' . $this->getData('krs_id') . '/umowy/' . $this->getId();
	}
		
}