<?

namespace MP\Lib;

class Instytucje extends DataObject
{
	
	protected $tiny_label = 'Instytucja';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Instytucja publiczna';
    }
	
	public function hasHighlights()
    {
        return false;
    }
    
    public function getThumbnailUrl($size = '2')
    {
		
        return $this->getData('avatar') ? 'http://mojepanstwo.pl/KtoTuRzadzi/img/instytucje/' . $this->getId() . '.png' : false;

    }
    
}