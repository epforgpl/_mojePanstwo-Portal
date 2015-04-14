<?

namespace MP\Lib;

class Krs_podmioty_zmiany extends DataObject
{
	
	protected $tiny_label = 'Zmiana';
	
	public function getUrl() {
		
		return '/dane/krs_podmioty/' . $this->getData('podmiot_id') . '/aktualnosci/' . $this->getId();
		
	}
	
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
		}
		
	}

}