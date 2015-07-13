<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Legislacja_projekty_uchwal extends DocDataObject
{
	
	protected $schema = array(
		array('autorzy_html', 'Autor'),
		array('opis', 'Opis', 'string', array(
			'truncate' => 120,
		)),
		array('status_str', 'Status'),
		array('data', 'Data', 'date')
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul_skrocony',
        'date' => 'data',
        'label' => 'label',
        'description' => 'opis',
    );
    
    protected $hl_fields = array(
    	'autorzy_html', 'status_str'
    );

    public function getLabel()
    {
        return 'Projekt uchwały Sejmu';
    }
    
    public function getFullLabel()
    {
        return 'Projekt uchwały Sejmu z ' . dataSlownie( $this->getDate() );
    }

}