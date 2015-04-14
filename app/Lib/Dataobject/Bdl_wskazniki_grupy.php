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
    
    /*
    public function getDescription()
    {
	    return 'W kategorii: <a href="/dane/bdl_wskazniki_kategorie/' . $this->getData('bdl_wskazniki_grupy.kategoria_id') . '">' . $this->getData('bdl_wskazniki_grupy.kategoria_tytul') . '</a>';
    }
    */

}