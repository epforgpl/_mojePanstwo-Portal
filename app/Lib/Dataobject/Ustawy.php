<?

namespace MP\Lib;

class Ustawy extends DataObject
{
	
	protected $tiny_label = 'Ustawa';
	
	protected $schema = array(
		array('prawo.status_id', 'Status', 'string', array(
			'dictionary' => array(
				'1' => 'Obowiązująca',
				'2' => 'Nieobowiązująca',
			),
		)),
		array('prawo.data_wydania', 'Data wydania'),
		array('prawo.data_publikacji', 'Data publikacji'),
		array('prawo.data_wejscia_w_zycie', 'Data wejścia w życie'),
	);
	
    protected $routes = array(
        'title' => 'prawo.tytul',
        'shortTitle' => 'prawo.tytul_skrocony',
        'date' => false,
    );
    
    protected $hl_fields = array(
    	'prawo.status_id', 'prawo.data_wydania', 'prawo.data_publikacji', 'prawo.data_wejscia_w_zycie'
    );

    public function getLabel()
    {
        return 'Ustawa';
    }
    
    public function getFullLabel()
    {
        return 'Ustawa z dnia ' . dataSlownie( $this->getData('prawo.data_wydania') );
    }

}