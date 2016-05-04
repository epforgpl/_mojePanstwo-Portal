<?

namespace MP\Lib;

class Sejm_glosowania extends DataObject
{
	
	protected $tiny_label = 'Głosowanie';
	
	public $dictionary = array(
	    '1' => array('Za', 'success'),
	    '2' => array('Przeciw', 'danger'),
	    '3' => array('Wstrzymanie', 'primary'),
	    '4' => array('Brak kworum', 'default'),
	);
	
	protected $schema = array(
		array('sejm_posiedzenia.tytul', 'Numer posiedzenia', 'string', array(
			'link' => array(
				'dataset' => 'sejm_posiedzenia',
				'object_id' => '$sejm_posiedzenia.id',
			),
		)),
		array('numer', 'Numer głosowania'),
		array('wynik_id', 'Wynik', 'vote'),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'czas',
        'time' => 'czas',
    );
    
    protected $hl_fields = array(
    	'wynik_id',
    );
    
    public function getLabel()
    {
        return 'Głosowanie w Sejmie';
    }
    
    public function getPosition() {
	    // return '#' . $this->getData('numer');
	    return false;
    }
    
    public function getUrl() {
	    
	    return '/dane/instytucje/3214,sejm/glosowania/' . $this->getData('id');	    
	    
    }
    
    public function getBreadcrumbs()
	{
		
		$label = $this->getData('sejm_posiedzenia.tytul');
		if( is_numeric($label) )
			$label = 'Posiedzenie #' . $label;
		
		return array(
			array(
				'id' => '/dane/instytucje/3214,sejm/posiedzenia/' . $this->getData('posiedzenie_id'),
				'label' => $label,
			),
			array(
				'id' => '/dane/instytucje/3214,sejm/posiedzenia/' . $this->getData('posiedzenie_id') . '/glosowania',
				'label' => 'Głosowania',
			),
		);
				
	}
    
    public function getSideLabel() {
	    
	    if( 
	    	array_key_exists($this->getData('wynik_id'), $this->dictionary) &&
	    	( $d = $this->dictionary[ $this->getData('wynik_id') ] )
	    )
		    return '<span class="label label-md label-' . $d[1] . '">' . $d[0] . '</span>';
		else
			return false;
    }
    
}