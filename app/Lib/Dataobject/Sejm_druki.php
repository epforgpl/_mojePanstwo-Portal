<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_druki extends DocDataObject
{

	protected $tiny_label = 'Druk sejmowy';
	protected $schema = array(
		array('druk_typ_nazwa', 'Typ druku'),
		array('numer', 'Numer druku')
	);
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul_skrocony',
        'date' => 'data',
        'label' => 'label'
    );
    protected $hl_fields = array(
    	'druk_typ_nazwa'
    );
	
	public function getShortTitle() {
		return $this->getData('tytul');
	}
	
	public function getTitle() {
		return $this->getData('tytul');
	}
	
    public function getLabel()
    {
        return $this->getData('sejm_druki_typy.nazwa');
    }

    public function getFullLabel()
    {
        return 'Druk sejmowy nr ' . $this->getData('numer') . ' z dnia' . dataSlownie( $this->getDate() );
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $numer = $this->getData('numer') )
			$output[] = 'Druk nr ' . $numer;
			
		$output[] = dataSlownie( $this->getDate() );
		
		$static = $this->getStatic();
		
		if( isset($static['tresc']) && !empty($static['tresc']) )
			$output[] = $static['tresc'];
		
		return $output;
		
	}
	
	public function getUrl() {
		
		return '/dane/instytucje/3214/druki/' . $this->getId() . ',' . $this->getSlug();
		
	}
	
	public function getThumbnailUrl($size = '2')
    {
        $dokument_id = $this->getData('dokument_id');
        return $dokument_id ? 'http://docs.sejmometr.pl/thumb/' . $size . '/' . $dokument_id . '.png' : false;
    }
	
	public function getBreadcrumbs()
	{
							
		return array(
			array(
				'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/druki',
				'label' => 'Druki sejmowe',
			),
		);
				
	}

}