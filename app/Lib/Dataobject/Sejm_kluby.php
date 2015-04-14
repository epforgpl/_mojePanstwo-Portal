<?

namespace MP\Lib;

class Sejm_kluby extends DataObject
{
	
	protected $tiny_label = 'Klub sejmowy';
	
	protected $schema = array(
		array('liczba_poslow', 'Liczba posłów'),
	);
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
    
    protected $hl_fields = array(
    	'liczba_poslow',
    );

    public function getLabel()
    {
        return 'Klub sejmowy';
    }
    
    public function getThumbnailUrl($size)
    {
	    return 'http://resources.sejmometr.pl/s_kluby/' . $this->getId() . '_t.png';
    }
    
    public function hasHighlights()
    {
        return false;
    }

}