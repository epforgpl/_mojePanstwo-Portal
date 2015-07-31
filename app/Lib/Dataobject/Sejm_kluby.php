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
    
    public function getThumbnailUrl($size = 2)
    {

        if($this->getData('avatar')) {
            return 'http://resources.sejmometr.pl/s_kluby/' . $this->getId() . '_t.png';
        }else{
            return false;
        }
    }
    
    public function hasHighlights()
    {
        return false;
    }

    public function getUrl() {

        return '/dane/instytucje/3214/kluby/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {

        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/kluby',
                'label' => 'Kluby i koła poselskie',
            ),
        );

    }

}