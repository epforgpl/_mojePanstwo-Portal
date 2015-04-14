<?

namespace MP\Lib;

class Prawo_hasla extends DataObject
{
	
	protected $tiny_label = 'Temat w prawie';
	
	protected $schema = array(
		array('liczba_aktow', 'Liczba aktów'),
	);
	
	protected $hl_fields = array(
		// 'liczba_aktow',
	);

    public function getLabel()
    {
        return 'Hasło w aktach prawnych';
    }
    
     protected $routes = array(
        'title' => 'q',
        'shortTitle' => 'q',
    );
    
    public function hasHighlights()
    {
        return false;
    }
    
}