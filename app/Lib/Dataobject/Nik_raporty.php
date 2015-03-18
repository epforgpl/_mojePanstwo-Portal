<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Nik_raporty extends DocDataObject
{
	
	protected $tiny_label = 'Raport NIK';
	
	protected $schema = array(
		array('data_publikacji', 'Data publikacji', 'date'),
		array('data_moderacji', 'Data moderacji', 'date'),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data_publikacji',
    );
	
	protected $hl_fields = array(
    	'data_publikacji', 'data_moderacji',
    );

    public function getLabel()
    {
        return 'Raport Najwyższej Izby Kontroli';
    }

}