<?

namespace MP\Lib;

class Bdl_wskazniki extends DataObject
{
	
	protected $tiny_label = 'Wskaźniki';
	
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
    );
    
    protected $hl_fields = array(
    	'kategoria_tytul', 'grupa_tytul', 'poziom_str', 'data_aktualizacji'
    );

    public function getLabel()
    {
        return 'Wskaźniki Banku Danych Lokalnych';
    }

}