<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_interpelacje_pisma extends DocDataObject
{
	
	protected $tiny_label = 'Pismo';
	
    public function __construct($params = array())
    {
        parent::__construct($params);
		
		// debug( $this->data );

    }
	
	protected $schema = array(
		array('sejm_interpelacje.poslowie_str', 'Od'),
		array('adresaci_str', 'Do'),
		array('autor_str', 'Odpowiadający'),
	);
	
    protected $routes = array(
        'title' => 'sejm_interpelacje.tytul',
        'shortTitle' => 'sejm_interpelacje.tytul_skrocony',
        'date' => 'data',
    );
	
	protected $hl_fields = array(
		'sejm_interpelacje.poslowie_str', 'adresaci_str'
	);
	
    public function getLabel()
    {
        $output = '<strong>';
        
        if( $this->getData('typ_id')=='1' )
        	$output .= 'Interpelacja';
        elseif( $this->getData('typ_id')=='2' )
        	$output .= 'Odpowiedź na interpelację';
        elseif( $this->getData('typ_id')=='2' )
        	$output .= 'Interpelacja ponowna';

        $output .= '</strong> nr ' . $this->getData('sejm_interpelacje.numer');
        return $output;
    }
    
    public function getHighlightsFields()
    {
	    
	    return array(
	    	'poslowie_str' => array(
	    		'label' => 'Od',
	    		'img' => 'http://resources.sejmometr.pl/mowcy/a/3/' . $this->getData('mowca_id') . '.jpg',
	    	),
	    	'adresaci_str' => 'Do',
	    );
	    	    
    }
    
    public function getUrl()
    {
	    
	    return '/dane/sejm_interpelacje/' . $this->getData('sejm_interpelacje.id') . '/pismo/' . $this->getData('id');
	    
    }
    
    public $force_hl_fields = true;

}