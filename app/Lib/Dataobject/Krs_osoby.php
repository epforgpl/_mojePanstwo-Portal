<?

namespace MP\Lib;

class Krs_osoby extends DataObject
{
	
	protected $tiny_label = 'Osoba';
	
	protected $schema = array(
		array('powiazania', 'Związany z'),
	);
	
	protected $hl_fields = array(
		'powiazania',
	);
	
    public function getTitle()
    {
        return $this->getData('imiona') . ' ' . $this->getData('nazwisko');
    }

    public function getShortTitle()
    {
        return $this->getTitle();
    }

    public function getLabel()
    {
        return '<strong>Osoba</strong> w Krajowym Rejestrze Sądowym';
    }
    
    public function getTitleAddon()
    {
    	if( $this->data['privacy']=='1' )
    		return false;
    	else
		    return '<span>' . substr($this->data('data_urodzenia'), 0, 4) . '\'</span>';
    }
	
	public function getData($field = '*')
    {
    	if( ($field=='powiazania') && (preg_match_all('/\<a(.*?)\/a\>/i', $this->getData('str'), $matches)) )	
    	{    
    		$items = array();
    		for( $i=0; $i<count($matches[0]); $i++ )
    			if( !in_array($matches[0][$i], $items) )
    				$items[] = $matches[0][$i];
    		return $items;
	    }
	    	
    	return parent::getData( $field );        
    }
    
    public function hasHighlights()
    {
        return false;
    }
}