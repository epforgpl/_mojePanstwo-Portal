<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Prawo_projekty extends DocDataObject
{
	
	protected $tiny_label = 'Projekt aktu prawnego';
	
	protected $schema = array(
		array('autorzy_html', ''),
		array('opis', 'Opis', 'string', array(
			'truncate' => 120,
		)),
		array('status_str', 'Status'),
		array('data', 'Data', 'date')
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data_start',
        'label' => 'label',
        'description' => 'opis',
    );
    
    protected $hl_fields = array(
    	'autorzy_html', 'status_str'
    );
	
	/*
    public function getLabel()
    {
	    $output = '';
	    
        switch( $this->getData('typ_id') ) {
	        case '1': { $output = 'Projekt ustawy'; break; }
	        case '2': { $output = 'Projekt uchwały'; break; }
	        case '5': { $output = 'Powołanie / odwołanie'; break; }
	        case '6': { $output = 'Umowa międzynarodowa'; break; }
	        case '11': { $output = 'Sprawozdanie kontrolne'; break; }
	        case '12': { $output = 'Projekt'; break; }
	        case '100': { $output = 'Zmiana w składach komisji'; break; }
	        case '103': { $output = 'Wniosek o referendum'; break; }
        }
        
        // $output .= ' z dnia ' . dataSlownie( $this->getDate() ); 
        
        return $output;
       
    }
    */
    
    public $autorzy_typy = array(
	    '1' => 'Projekt rządowy',
	    '2' => 'Projekt obywatelski',
	    '3' => 'Projekt komisyjny',
	    '4' => 'Projekt senacki',
	    '5' => 'Projekt poselski',
	    '6' => 'Projekt prezydencki',
	    '7' => 'Projekt prezydialny',
    );
    
    public function getThumbnailUrl($size = '2')
    {
        if( $dokument_id = $this->getData('dokument_id') )
		    return $dokument_id ? 'http://docs.sejmometr.pl/thumb/' . $size . '/' . $dokument_id . '.png' : false;
		else
			return false;
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array(
			dataSlownie( $this->getDate() )
		);
		
		if( $druk_nr = $this->getData('druk_nr') ) {
			$output[] = 'Druk nr ' . $druk_nr;
		}
		
		if( $autor_typ_id = $this->getData('autor_typ_id') ) {
			$output[] = $this->autorzy_typy[$autor_typ_id];
		}
									
		return $output;
		
	}
    
    public $force_hl_fields = true;

}