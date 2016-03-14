<?

namespace MP\Lib;

class Msig_pozycje extends DataObject
{
		
	public function getUrl() {
		
		if( $this->getData('krs_slug') )
			return '/' . $this->getData('krs_slug') . '/ogloszenia/' . $this->getId();
		else
			return '/dane/krs_podmioty/' . $this->getData('krs_id') . '/ogloszenia/' . $this->getId();
		
	}
	
	public $routes = array(
		'desc' => 'skrot',
		'date' => 'msig.data',
	);
	
	public function getShortTitle() {
		
		if( 
			$this->getOptions('from_msig') && 
			$this->getData('nazwa')
		) {
			
			return $this->getData('nazwa');
			
		} else {
		
			switch( $this->getData('msig_dzialy.typ_id') ) {
				case '3': return 'Ogłoszenie handlowe';
				case '4': return 'Ogłoszenie w sprawie upadłości';
				case '5': return 'Ogłoszenie w sprawie cywilnej';
				case '6': return 'Zmiana adresu siedziby';
				case '7': return 'Zmiana organu sprawującego nadzór';
				case '8': return 'Zmiana danych rejestrowych';
				case '12': return 'Zmiana celu działania organizacji';
				default: return 'Ogłoszenie';
			}
		
		}
		
	}
	
	public function getTitle() {
		return $this->getShortTitle();
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
							
			if( $this->getData('krs_id') )
				$output[] = 'KRS ' . str_pad($this->getData('krs_id'), '10', '0', 0);
				
			if( $this->getData('pozycja') )
				$output[] = 'Pozycja ' . $this->getData('pozycja');
			
		} else {
		
			if( $this->getDate() )
				$output[] = dataSlownie( $this->getDate() );
		
		}
		
        return $output;

    }

}