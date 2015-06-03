<?

namespace MP\Lib;

class Krakow_komisje_posiedzenia extends DataObject
{
	
	protected $tiny_label = 'Samorząd';
	
	protected $schema = array(
		array('krakow_komisje.nazwa', '', 'string', array(
			'link' => array(
				'dataset' => 'krakow_komisje',
				'object_id' => '$krakow_komisje.id',
			),
		)),
	);
   
    protected $hl_fields = array(
    	'krakow_komisje.nazwa'
    );
        
    protected $routes = array(
        'title' => 'data',
        'shortTitle' => 'data',
        'date' => 'data',
    );

    public function getLabel()
    {
        return 'Druk w pracach rady gminy <a href="/dane/gminy/903">Kraków</a>';
    }
    
    public function getShortTitle() {
	    
	    return dataSlownie( $this->getData('data') );
	    
    }
    
    public function getTitle() {
	    
	    return 'Posiedzenie ' . dataSlownie( $this->getData('data') );
	    
    }

    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/komisje/' . $this->getData('komisja_id') . '/posiedzenia/' . $this->getId();
    }
	
	public function getThumbnailUrl($size = '3')
    {
    	if( $this->getData('yt_video_id') )
	        return 'http://img.youtube.com/vi/' . $this->getData('yt_video_id') . '/mqdefault.jpg';
	    else
	        return '/dane/pk/posiedzenie.jpg';
    }
    
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array(
			$this->getData('krakow_komisje.nazwa'),
		);
		
		
		return $output;
		
	}
	
}