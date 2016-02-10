<?

namespace MP\Lib;

class Krakow_posiedzenia_wystapienia extends DataObject
{

    protected $routes = array(
        'title' => 'skrot',
        'shortTitle' => 'skrot',
        'date' => 'krakow_posiedzenia.data',
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
		
		if( $this->getData('punkt_id') )
	        return '/dane/gminy/903,krakow/punkty/' . $this->getData('punkt_id') . '/wystapienia/' . $this->getId();
		else
	        return '/dane/gminy/903,krakow/wystapienia/' . $this->getId();
		
    }
    
    public function getSlug() {
	    return false;
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
					
		if( $date = $this->getDate() )
			$output[] = dataSlownie($date);
			
		if( $txt = $this->getData('krakow_posiedzenia_punkty.tytul') ) {
			$trim_txt = mb_substr($txt, 0, 70);
			if( strlen($trim_txt) < strlen($txt) )
				$trim_txt .= '...';
			$output[] =  $trim_txt;
		}
				
        return $output;

    }
    
}