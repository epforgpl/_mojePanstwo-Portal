<?

namespace MP\Lib;

class Bdl_wskazniki_kategorie extends DataObject
{
	
	protected $tiny_label = 'Wskaźniki';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
    );

    public function getLabel()
    {
        return 'Kategoria wskaźników Banku Danych Lokalnych';
    }

}