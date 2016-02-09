<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sprawozdania_opp extends DocDataObject
{
	
	protected $tiny_label = 'Sprawozdanie OPP';
	
	public function getShortTitle() {
		return $this->getData('krs_podmioty.nazwa');
	}
	
	public function getUrl() {
		return '/dane/krs_podmioty/' . $this->getData('krs_podmioty.id') . '/sprawozdania_opp/' . $this->getId();
	}
	
	public function getTitle() {
		return $this->getShortTitle();
	}    
	
    public function getLabel() {
        return 'Sprawozdanie OPP';
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array('Za rok ' . $this->getData('rocznik'));
		
		
		if( $date = $this->getData('data_min') )
			$output[] = 'Złożono ' . dataSlownie( $date );
	
		return $output;
		
	}
	
	public function getThumbnailUrl($size = '2')
    {
        $dokument_id = $this->getData('dokument_id');
        return $dokument_id ? 'http://docs.sejmometr.pl/thumb/' . $size . '/' . $dokument_id . '.png' : false;
    }
		
}