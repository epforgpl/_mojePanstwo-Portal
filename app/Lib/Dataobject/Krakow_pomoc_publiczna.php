<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_pomoc_publiczna extends DocDataObject
{
	
	protected $tiny_label = 'Pomoc publiczna';
	
    protected $routes = array(
        'title' => 'beneficjent',
        'shortTitle' => 'beneficjent',
    );

    public function getLabel()
    {
        return 'Pomoc publiczna';
    }
	
	public function getUrl()
	{
		return false;
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $this->getData('wartosc') )
			$output[] = number_format_h($this->getData('wartosc')) . ' PLN';
			
		if( $this->getData('przeznaczenie') )
			$output[] = $this->getData('przeznaczenie');
			
		if( $this->getData('rok') )
			$output[] = 'Rok ' . $this->getData('rok');
						
		return $output;
		
	}
		
}