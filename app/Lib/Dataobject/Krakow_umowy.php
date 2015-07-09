<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_umowy extends DocDataObject
{
	
	protected $tiny_label = 'Pomoc publiczna';
	
    protected $routes = array(
        'title' => 'przedmiot_umowy',
        'shortTitle' => 'przedmiot_umowy',
    );

    public function getLabel()
    {
        return 'Umowa';
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
			
		if( $this->getData('data_zawarcia') )
			$output[] = dataSlownie($this->getData('data_zawarcia'));
									
		return $output;
		
	}
		
}