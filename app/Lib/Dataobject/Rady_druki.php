<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Rady_druki extends DocDataObject
{
	
	protected $tiny_label = 'Samorząd';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
    );

    public function getLabel()
    {
        return 'Druk w pracach rady gminy <a href="/dane/gminy/903">Kraków</a>';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/' . $this->getData('gmina_id') . '/druki/' . $this->getId();
    }

}