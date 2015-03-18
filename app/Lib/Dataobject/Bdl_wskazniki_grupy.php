<?

namespace MP\Lib;

class Bdl_wskazniki_grupy extends DataObject
{
	
	protected $tiny_label = 'Wskaźniki';
	
	protected $schema = array(
		array('kategoria_tytul', 'Kategoria', 'string', array(
			'link' => array(
				'dataset' => 'bdl_wskazniki_kategorie',
				'object_id' => '$kategoria_id',
			),
		)),
	);
	
	protected $hl_fields = array(
    	'kategoria_tytul',
    );
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
    );

    public function getLabel()
    {
        return '<strong>Grupa wskaźników</strong> Banku Danych Lokalnych';
    }

}