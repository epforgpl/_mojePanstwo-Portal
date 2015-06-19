<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_posiedzenia_punkty extends DocDataObject
{
	
	protected $tiny_label = 'Samorząd';
	
	protected $schema = array(
		array('druk_id', 'Druk', 'string', array(
			'link' => array(
				'dataset' => 'rady_druki',
				'object_id' => '$druk_id',
			),
		)),
		array('numer_punktu', 'Punkt', 'string'),
		array('opis', 'Temat')
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'krakow_posiedzenia.data',
        'position' => 'numer_str',
        'description' => 'opis',
    );
    
    protected $hl_fields = array();
	
	public function __construct($params = array())
    {

        parent::__construct($params);
		
		/*
        if( $this->getData('druk_id') ) {
        	$this->hl_fields[] = 'druk_id';
        }
        */

    }
	
    public function getThumbnailUrl($size = '3')
    {
    	if( $this->getData('yt_video_id') )
	        return 'http://img.youtube.com/vi/' . $this->getData('yt_video_id') . '/mqdefault.jpg';
	    else
	    	return false;
    }
	
	public function getShortLabel()
    {
        return '<a class="link-discrete" href="/dane/gminy/903,krakow/posiedzenia/' . $this->getData('krakow_posiedzenia.id') . '">Posiedzenie ' . dataSlownie($this->getData('krakow_posiedzenia.data')) . '</a> <span class="separator">|</span> Punkt #' . $this->getData('numer');
    }
	
    public function getLabel()
    {
        return 'Debata na posiedzeniu <strong>' . $this->getData('gminy.rada_nazwa_dopelniacz') . '</strong>';
    }
    
	public function getUrl()
	{
		if( 
		    $this->getData('glosowanie_id') || 
		    $this->getData('yt_video_id') 
	    )
	    	return '/dane/gminy/903,krakow/punkty/' . $this->getId();
	    else
	    	return false;
		
	}
    
    public function hasHighlights(){
	    return false;
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
				
		if( $this->getData('rady_druki.tytul') )
			$output[] = $this->getData('rady_druki.tytul');
			
		if( $this->getData('wynik_str') )
			$output[] = $this->getData('wynik_str');
		
		return $output;
		
	}
	
	public function getBreadcrumbs()
	{
				
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/posiedzenia',
				'label' => 'Posiedzenia Rady Miasta',
			),
			array(
				'id' => '/dane/gminy/903,krakow/posiedzenia/' . $this->getData('krakow_posiedzenia.id'),
				'label' => dataSlownie($this->getData('krakow_posiedzenia.data')),
			),
			array(
				'label' => 'Punkt #' . $this->getData('numer'),
			),
		);
				
	}

}