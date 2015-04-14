<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Rady_druki extends DocDataObject
{
	
	protected $tiny_label = 'Samorząd';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'date' => 'data',
        'desc' => false,
    );

    public function getLabel()
    {
        return 'Druk w pracach rady gminy <a href="/dane/gminy/903">Kraków</a>';
    }
    
    public function getShortLabel()
    {
        return 'Projekt legislacyjny';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/' . $this->getData('gmina_id') . '/druki/' . $this->getId();
    }
    
    public function getDescription()
    {
	    return false;
    }
        
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array(
			dataSlownie($this->getData('rady_druki.data')),
			$this->getData('rady_druki.tytul'),
			$this->getData('rady_druki.autor_str'),
		);
				
		return $output;
		
	}

}