<?

namespace MP\Lib;

class Kody_pocztowe extends DataObject
{
	
	protected $tiny_label = 'Kod pocztowy';
	
	protected $schema = array(
		array('gminy_str', 'Gminy'),
	);
	
    protected $routes = array(
        'title' => 'kod',
        'shortTitle' => 'kod',
    );
	
	protected $hl_fields = array('gminy_str');
	
    public function getLabel()
    {
        return 'Kod pocztowy';
    }

}