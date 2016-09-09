<?

namespace MP\Lib;

class Msig_pozycje extends DataObject
{
		
    public $force_hl_fields = true;
	
	public function getShortLabel() {
		return "Ogłoszenie w Monitorze Sądowym i Gospodarczym";
	}
	
	public function getUrl() {
		
		if( $this->getData('krs_id') )
			return '/dane/krs_podmioty/' . $this->getData('krs_id') . '/ogloszenia/' . $this->getId();
		else
			return '/dane/msig_pozycje/' . $this->getId();
		
	}
	
	public $routes = array(
		'desc' => 'skrot',
		'date' => 'msig.data',
	);
	
	public function getLabel() {
		
		return "Ogłoszenie w Monitorze Sądowym i Gospodarczym";
				
	}
	
	public function getShortTitle($preset = false) {
		
		if(
			!$preset && 
			$this->getOptions('titlePreset')
		)
			$preset = $this->getOptions('titlePreset');
				
		$parts = array();
		
		if( $preset != 'from_msig' )
			$parts[] = 'MSiG z ' . dataSlownie($this->getData('msig.data'), array('relative' => false));
			
		$parts[] = 'Pozycja ' . $this->getData('pozycja');
		
		if( 
			(
				!$preset || 
				( $preset == 'from_msig' )
			) && 
			( $nazwa = $this->getData('nazwa') )
		) {
			
			$parts[] = $nazwa;

		}
		
		return implode(' &mdash; ', $parts);
		
	}
	
	public function getTitle() {
		return $this->getShortTitle();
	}
	
	public function getPageDescription() {
		return $this->getData('msig_dzialy.nazwa');
	}
	
	public function getDescription() {
				
		if( $this->getOptions('fromObject') )
			return false;
		else
			return $this->getData('skrot');
		
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		if( $this->getOptions('from_msig') ) {
			
			/*	
			if( $this->getData('krs_id') )
				$output[] = 'KRS ' . str_pad($this->getData('krs_id'), '10', '0', 0);
			*/
				
			if( $this->getData('msig_dzialy.nazwa') )
				$output[] = $this->getData('msig_dzialy.nazwa');
							
		} else {
			
			/*
			if( $this->getDate() )
				$output[] = dataSlownie( $this->getDate() );
			*/
			
			if( $this->getData('msig_dzialy.nazwa') )
				$output[] = $this->getData('msig_dzialy.nazwa');
		
		}
		
        return $output;

    }

}