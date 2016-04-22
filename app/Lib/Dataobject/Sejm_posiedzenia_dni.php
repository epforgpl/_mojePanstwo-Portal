<?

namespace MP\Lib;

class Sejm_posiedzenia_dni extends DataObject
{
	
	protected $months = array(
		'', 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień',
	);
	
	protected $days = array(
		'', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela'
	);
	
	protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
    );
	
	public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		if( $this->getData('liczba_wystapien') )
			$output[] = pl_dopelniacz($this->getData('liczba_wystapien'), 'wystąpienie', 'wystąpienia', 'wystąpień');
			
		if( $this->getData('liczba_glosowan') )
			$output[] = pl_dopelniacz($this->getData('liczba_glosowan'), 'głosowanie', 'głosowania', 'głosowań');
		
		return $output;
		
	}
	
	public function getUrl() {
		
		return '/dane/instytucje/3214,sejm/punkty/' . $this->getId();
		
	}
	
	public function getTitle() {
		return dataSlownie( $this->getDate() );
	}
	
	public function getMonth() {
		
		$date = strtotime($this->getDate());
		return $this->months[ date('n', $date) ];
		
	}
	
	public function getDay() {
		
		$date = strtotime($this->getDate());
		return $this->days[ date('N', $date) ];
		
	}

}