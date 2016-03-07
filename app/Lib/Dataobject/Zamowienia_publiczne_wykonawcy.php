<?

namespace MP\Lib;

class Zamowienia_publiczne_wykonawcy extends DataObject
{
	
    public $force_hl_fields = true;

    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Wykonawca zamówień publicznych';
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		if( $this->getData('miejscowosc') )
			$output[] = $this->getData('miejscowosc');
				
        return $output;

    }
	
}