<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Wybory_darczyncy extends DocDataObject
{
	
	protected $tiny_label = 'Osoba';
	
	protected $schema = array(
		array('rady_gmin_komitety.skrot_nazwy', 'Obdarowany komitet', 'string'),
	);
	
	public $hl_fields = array(
		'rady_gmin_komitety.skrot_nazwy'
	);
	
    public function getUrl()
    {
        return false;
    }

    public function getTitle()
    {
        return 'Darowizna ' . $this->getData('imie') . ' ' . $this->getData('nazwisko') . ' na rzecz ' . $this->getData('rady_gmin_komitety.nazwa');

    }

    public function getShortTitle()
    {
        return $this->getData('imie') . ' ' . $this->getData('nazwisko');

    }
    
    public function getTitleAddon()
    {
	    return number_format($this->getData('wartosc_kwota'), 0, '', ' ') . ' PLN';
    }

    public function getLabel()
    {

        return 'Darowizna na rzecz komitetu wyborczego';

    }
    
    public function hasHighlights()
    {
        return false;
    }

}