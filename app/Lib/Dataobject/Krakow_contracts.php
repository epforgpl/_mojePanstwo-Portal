<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_contracts extends DocDataObject
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
	    return '/dane/gminy/903,krakow/umowy/' . $this->getId();
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $this->getData('kwota') )
			$output[] = number_format_h($this->getData('kwota')) . ' PLN';
			
		if( $this->getData('kontrahent') )
			$output[] = $this->getData('kontrahent');
			
		if( $this->getData('data_zawarcia') ) {
			$output[] = dataSlownie($this->getData('data_zawarcia'));
		} elseif ($this->getData('data_wprowadzenia')) {
			$output[] = dataSlownie($this->getData('data_wprowadzenia'));
		}
									
		return $output;
		
	}
		
}