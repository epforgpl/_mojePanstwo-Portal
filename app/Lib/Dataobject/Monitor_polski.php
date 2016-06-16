<?

namespace MP\Lib;
require_once( 'DocDataObject.php' );

class Monitor_polski extends DocDataObject
{

    public $force_hl_fields = true;
	protected $tiny_label = 'Prawo';
	protected $schema = array(
		array('id', 'ID'),
		array('sygnatura', 'Sygnatura'),
		array('data_wydania', 'Data wydania'),
		array('data_publikacji', 'Data publikacji'),
		array('data_wejscia_w_zycie', 'Data wejścia w życie'),
		array('isap_status_str', 'Status'),
	);
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul_skrocony',
        'date' => 'data_publikacji',
        'label' => 'label'
    );
    protected $hl_fields = array(
    	'isap_status_str', 'sygnatura', 'data_publikacji', 'data_wejscia_w_zycie'
    );

    public function getLabel() {

        // return $this->getData('status_id');
	    return $this->getData('label');
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
					
		$output = array();
		
		if( $this->getData('sygnatura') )
			$output[] = $this->getData('sygnatura');
		
		if( $this->getData('data_publikacji') )
			$output[] = 'Opublikowano ' . dataSlownie($this->getData('data_publikacji'));
				
        return $output;

    }

}