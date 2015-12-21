<?

namespace MP\Lib;

class Krakow_posiedzenia_wystapienia extends DataObject
{

    protected $routes = array(
        'title' => 'skrot',
        'shortTitle' => false,
        'date' => 'data',
    );  

    public function getLabel()
    {
	    debug( $this->getData() );
        return 'Wystąpienie';
    }

    public function getThumbnailUrl($size = '0')
    {

        return false;

    }

    public function hasHighlights(){
        return false;
    }

    public function getUrl() {

        return '/dane/instytucje/3214,sejm/debaty/' . $this->getData('debata_id') . '/wystapienia/' . $this->getId();

    }
    
    public function getSlug() {
	    return false;
    }
    
    public function getIcon() {
	    return false;
    }
    
}