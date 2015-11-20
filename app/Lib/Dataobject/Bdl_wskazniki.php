<?

namespace MP\Lib;

class Bdl_wskazniki extends DataObject
{
	
	protected $tiny_label = 'Wskaźniki';
    public $force_hl_fields = true;

	protected $schema = array(
		array('kategoria_tytul', 'Kategoria', 'string', array(
			'link' => array(
				'dataset' => 'bdl_wskazniki_kategorie',
				'object_id' => '$kategoria_id',
			),
			'normalizeText' => true,
		)),
		array('grupa_tytul', 'Grupa', 'string', array(
			'link' => array(
				'dataset' => 'bdl_wskazniki_grupy',
				'object_id' => '$grupa_id',
			),
		)),
		array('poziom_str', 'Szczegółowość'),
		array('data_aktualizacji', 'Data aktualizacji'),
	);
		
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => false,
        'description' => 'opis',
    );

    public function getLabel()
    {
        return 'Wskaźnik';
    }
    
    public function getDescription()
    {
	    // debug( $this->getData() );
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
						
		if( $this->getData('liczba_ostatni_rok') )
			$output[] = 'Ostatnia wartość z ' . $this->getData('liczba_ostatni_rok') . ' r.';
		
		if( $this->getData('poziom_str') )
			$output[] = $this->getData('poziom_str');
				
		return $output;
		
	}
	
	public function hasHighlights()
    {
        return false;
    }

}