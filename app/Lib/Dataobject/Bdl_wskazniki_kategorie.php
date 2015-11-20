<?

namespace MP\Lib;

class Bdl_wskazniki_kategorie extends DataObject
{
	
	protected $tiny_label = 'Wskaźniki';
    public $force_hl_fields = true;

    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
    );

    public function getLabel()
    {
        return 'Kategoria wskaźników';
    }

}