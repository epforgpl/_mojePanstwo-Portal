<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Rady_gmin_interpelacje extends DocDataObject
{
	
	protected $tiny_label = 'Interpelacja';
	
	protected $schema = array(
		array('posiedzenie_nr', 'Posiedzenie nr'),
		array('radni_gmin.nazwa', 'Autor', 'string', array(
			'link' => array(
				'dataset' => 'radni_gmin',
				'object_id' => '$radny_id',
			),
		)),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
    );
    
    protected $hl_fields = array(
    	'radni_gmin.nazwa',
    );
	
	public function getShortTitle()
	{
		
		if( stripos($this->getData('tytul'), 'w sprawie')===0 )
			return $this->getData('tytul');
		else
			return 'w sprawie ' . lcfirst($this->getData('tytul'));
	}
	
	public function getShortLabel(){
		return $this->getLabel();
	}
	
    public function getLabel()
    {
        return 'Interpelacja w sprawie';
    }
    
    public function getFullLabel()
    {
    	if( $this->getData('radni_gmin.plec')=='K' )
	        return 'Interpelacja radnej gminy w sprawie';
	    else
	        return 'Interpelacja radnego gminy w sprawie';
    }

    public $force_hl_fields = true;
	
	public function getUrl()
	{
		return '/dane/gminy/' . $this->getData('radni_gmin.gmina_id') . '/interpelacje/' . $this->getId();
	}
	
}