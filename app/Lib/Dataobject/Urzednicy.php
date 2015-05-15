<?

namespace MP\Lib;

class Urzednicy extends DataObject
{
	
	protected $tiny_label = 'Urzędnicy';
	
	protected $schema = array(	
		array('stanowisko', 'Stanowisko'),
	);
	
	protected $hl_fields = array(
    	'stanowisko',
    );
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Urzędnik';
    }

    public function getIcon()
    {
        return '<i class="object-icon glyphicon" data-icon-datasets="&#xe627;"></i>';
    }

    public function hasHighlights()
    {
        return false;
    }

}