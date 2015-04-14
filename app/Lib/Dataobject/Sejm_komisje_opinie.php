<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_komisje_opinie extends DocDataObject
{
	
	protected $tiny_label = 'Sejm';
	
    public function getLabel()
    {
        return '<strong>Opinia</strong> ' . $this->getData('sejm_komisje.dopelniacz');
    }

    public function getShortTitle()
    {
        return $this->getData('tytul');
    }

    public function getTitle()
    {
        return $this->getShortTitle();
    }
} 