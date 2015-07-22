<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_darczyncy extends DocDataObject
{
	
	protected $tiny_label = 'Pomoc publiczna';
	
    protected $routes = array(
        'title' => 'beneficjent',
        'shortTitle' => 'beneficjent',
    );

    public function getLabel()
    {
        return 'Darczyńca';
    }
	
	public function getUrl()
	{
		return false;
	}
	
	public function getTitle()
	{
		return $this->getShortTitle();
	}
	
	public function getShortTitle()
	{
		return $this->getData('imie') . ' ' . $this->getData('nazwisko');
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $this->getData('wartosc_laczne_wplaty') )
			$output[] = number_format_h($this->getData('wartosc_laczne_wplaty')) . ' PLN';
				
		if( $this->getData('krakow_darczyncy_komitety.nazwa') )
			$output[] = $this->getData('krakow_darczyncy_komitety.nazwa');
										
		return $output;
		
	}
		
}