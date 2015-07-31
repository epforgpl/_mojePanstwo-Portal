<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Nik_raporty_dokumenty extends DocDataObject
{
	
	protected $tiny_label = 'Raport NIK';
	
	protected $schema = array(
		array('data_publikacji', 'Data publikacji', 'date'),
		array('data_moderacji', 'Data moderacji', 'date'),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data_publikacji',
        'titleAddon' => 'nik_raporty.tytul',
    );
	
	protected $hl_fields = array(
    	'data_publikacji', 'data_moderacji',
    );

    public function getLabel()
    {
        return 'Raport Najwyższej Izby Kontroli';
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
    
    public function getShortTitle()
    {
	    if( isset($this->options['mode']) && ($this->options['mode']==='raport') )
			return $this->getData('nik_jednostki.nazwa') ? $this->getData('nik_jednostki.nazwa') : $this->getData('nik_raporty_dokumenty.nazwa');
		else
		    return $this->getData('nik_raporty_dokumenty.nazwa');
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
				
		if( $this->getDate() )
			$output[] = dataSlownie($this->getDate());
		
		if( isset($this->options['mode']) && ($this->options['mode']==='raport') && ($this->getData('nik_jednostki.nazwa')) )
			$output[] = $this->getData('nik_raporty_dokumenty.nazwa');
		
		if( $this->getData('nik_raporty_podmioty.nazwa') )
			$output[] = 'Podmiot kontrolowany: ' . $this->getData('nik_raporty_podmioty.nazwa');
			
		if( isset($this->options['mode']) && ($this->options['mode']==='subobject') && $this->getData('nik_jednostki.nazwa') ) 
			$output[] = 'Jednostka kontrolujaca: ' . $this->getData('nik_jednostki.nazwa');
			
							
		return $output;
		
	}
	
	public function getUrl() {
		
		$url = '/dane/instytucje/3217,najwyzsza-izba-kontroli/raporty/' . $this->getData('nik_raporty.id') . '/dokumenty/' . $this->getId();
		if( $this->getSlug() )
			$url .= ',' . $this->getSlug();
			
		return $url;
		
	}
	
	public function getBreadcrumbs()
	{
				
		return array(
			array(
				'id' => '/dane/instytucje/3217,najwyzsza-izba-kontroli/raporty/' . $this->getData('nik_raporty.id'),
				'label' => $this->getData('nik_raporty.tytul'),
			),
		);
	}

}