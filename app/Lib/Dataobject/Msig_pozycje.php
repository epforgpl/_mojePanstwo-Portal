<?

namespace MP\Lib;

class Msig_pozycje extends DataObject
{
		
	public function getUrl() {
		
		return '/dane/krs_podmioty/' . $this->getData('krs_id') . '/ogloszenia/' . $this->getId();
		
	}
	
	public $routes = array(
		'desc' => 'skrot'
	);
	
	public function getShortTitle() {
		
		switch( $this->getData('typ_id') ) {
			case '1': return 'Zmiana danych organu reprezentacji';
			case '2': return 'Zmiana przedmiotu działalności';
			case '3': return 'Wzmianka o dokumentach złożonych do KRS';
			case '4': return 'Zmiana danych organu nadzoru';
			case '5': return 'Zmiana statutu';
			case '6': return 'Zmiana adresu siedziby';
			case '7': return 'Zmiana organu sprawującego nadzór';
			case '8': return 'Zmiana danych rejestrowych';
			case '12': return 'Zmiana celu działania organizacji';
			default: return 'Ogłoszenie';
		}
		
	}
	
	public function getDescription() {
		
		return $this->getData('skrot');
		// debug( $this->getData() );
		
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		if( $this->getDate() )
			$output[] = dataSlownie( $this->getDate() );
				
        return $output;

    }

}