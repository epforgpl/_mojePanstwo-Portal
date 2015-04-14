<?

namespace MP\Lib;

class Gminy extends DataObject
{
	
	protected $tiny_label = 'Gmina';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'label' => 'typ_nazwa',
    );
	
    public function getThumbnailUrl($size = 'default')
    {
        return 'http://resources.sejmometr.pl/gminy/thumbs/png/' . $this->getId() . '.png';
    }
	
	public function hasHighlights()
    {
        return false;
    }
}