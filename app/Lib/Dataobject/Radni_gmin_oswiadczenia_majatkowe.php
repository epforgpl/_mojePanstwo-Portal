<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Radni_gmin_oswiadczenia_majatkowe extends DocDataObject
{
	
	protected $tiny_label = 'Oświadczenie majątkowe';
	
	protected $schema = array(
	);
	
    protected $routes = array(
        'title' => 'rok',
        'shortTitle' => 'rok',
    );
	
	protected $hl_fields = array();
	
	

    public function getLabel()
    {
        return 'Oświadczenie majątkowe radnego: <strong>' . $this->getData('radni_gmin.nazwa') . '</strong>';
    }

    public function getUrl()
    {
        return '/dane/' .
        'gminy' . '/' . $this->getData('radni_gmin.gmina_id') . '/' . 
        'radni' . '/' . $this->getData('radny_id') . '/' . 
        'oswiadczenia' . '/' . $this->getId();
    }


}