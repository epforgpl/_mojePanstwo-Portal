<?

namespace MP\Lib;

class Coe_sittings extends DataObject
{
	
	protected $tiny_label = 'Rada Europy';
		
	protected $schema = array(
		array('powiazania', 'Związany z'),
	);
	
    protected $routes = array(
		'date' => 'date',
	);
	
    public function getTitle()
    {
    	$session_title = $this->getData('coe_sessions.title');
    	if( !$session_title )
    		$session_title = 'Session';
    		
        return $session_title . ' / ' . $this->getData('time_str');
    }

    public function getShortTitle()
    {
        return $this->getTitle();
    }

    public function getLabel()
    {
        return '<strong>Council of Europe</strong> sitting';
    }

}