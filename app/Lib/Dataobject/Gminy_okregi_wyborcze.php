<?

namespace MP\Lib;

class Gminy_okregi_wyborcze extends DataObject
{
	
	protected $tiny_label = 'Okręg wyborczy';
	
	protected $schema = array(
		array('liczba_wyborcow', 'Liczba wyborców', 'integer'),
		array('liczba_kandydatow', 'Liczba kandydatów', 'integer'),
		array('liczba_mandatow', 'Liczba mandatów', 'integer'),
		
	);
    
    protected $hl_fields = array(
    	'liczba_wyborcow', 'liczba_kandydatow', 'liczba_mandatow', 'liczba_komitetow'
    );
    
    protected $routes = array(
        'title' => 'numer',
        'shortTitle' => 'numer',
        'label' => true,
    );	
		
    public $force_hl_fields = true;
    
    public function getLabel() {
		
		if( !$this->routes['label'] )
			return false;
			
		return '<strong>Okręg wyborczy</strong> w gminie ' . $this->getData('gminy.nazwa');
		
	}
	
	public function getTitle() {
		
		return 'Okręg wyborczy #' . $this->getData('numer') . ' w gminie <a href="/dane/gminy/' . $this->getData('gmina_id') . '">' . $this->getData('gminy.nazwa') . '</a>';
		
	}
	
	public function getShortTitle() {
		
		return '#' . $this->getData('numer');
		
	}
	
	public function getDescription(){
		return $this->getData('granice_obwodu');
	}
	
	public function getUrl(){
		return '/dane/gminy/' . $this->getData('gmina_id') . '/okregi_wyborcze/' . $this->getId();
	}
    
}