<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_zamowienia_publiczne extends DocDataObject
{
	
	protected $tiny_label = 'Zamówienie publiczne';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Zamówienie publiczne';
    }
	
	public function getUrl()
	{
		return false;
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $this->getData('wartosc_brutto') )
			$output[] = number_format_h($this->getData('wartosc_brutto')) . ' PLN';
			
		if( $this->getData('wykonawca') )
			$output[] = $this->getData('wykonawca');
			
		if( $this->getData('rok') )
			$output[] = 'Rok ' . $this->getData('rok');
						
		return $output;
		
	}
		
}