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
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		if( $this->getData('gminy.typ_nazwa') )
			$output[] = $this->getData('gminy.typ_nazwa');
		
		if( $this->getData('gminy.liczba_ludnosci') )
			$output[] = 'Liczba mieszkańców: ' . number_format_h($this->getData('gminy.liczba_ludnosci'));
			
		return $output;
		
	}
	
}