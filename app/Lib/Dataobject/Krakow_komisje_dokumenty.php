<?

namespace MP\Lib;

class Krakow_komisje_dokumenty extends DataObject
{
	
    protected $routes = array(
        'date' => 'krakow_komisje_posiedzenia.data',
    );

    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/komisje_opinie/' . $this->getId();
    }
	
	public function getThumbnailUrl($size = '2')
    {
	    if( isset($this->options['mode']) && ($this->options['mode']==='subobject') ) {
	    	return false;
	    } else {
	        $dokument_id = $this->getData('dokument_id');
	        return $dokument_id ? 'http://docs.sejmometr.pl/thumb/' . $size . '/' . $dokument_id . '.png' : false;
        }
    }
	
	public function getBreadcrumbs()
	{
				
		return array(
			array(
				'id' => '/dane/gminy/903,krakow/komisje',
				'label' => 'Komisje Rady Miasta',
			),
			array(
				'id' => '/dane/gminy/903,krakow/komisje/' . $this->getData('krakow_komisje.id'),
				'label' => $this->getData('krakow_komisje.nazwa'),
			),
			array(
				'id' => '/dane/gminy/903,krakow/komisje/' . $this->getData('krakow_komisje.id') . '/opinie',
				'label' => 'Opinie prawne'
			),
		);
				
	}
	
	public function getMetaDescriptionParts($preset = false)
	{

		$output = array();
						
		if( $this->getDate() )
			$output[] = dataSlownie( $this->getDate() );
		
		if( $this->getData('krakow_komisje.nazwa') )
			$output[] = '<a href="#">' . $this->getData('krakow_komisje.nazwa') . '</a>';
				
        return $output;

    }
	
}