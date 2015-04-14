<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Rady_druki_dokumenty extends DocDataObject
{
	
	protected $tiny_label = 'Samorząd';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
    );

    public function getLabel()
    {
        return 'Dokument do druku';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/druki/' . $this->getData('druk_id') . '/dokumenty/' . $this->getId();
    }

}