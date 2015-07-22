<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Urzednicy_rejestr_korzysci extends DataObject
{
	
	protected $tiny_label = 'Rejestr korzyści';

    public function getTitle()
    {
        return $this->getShortTitle();
    }

	public function getShortTitle() {

        if ($this->getData('typ') == 'u') {
            return $this->getData('za_osobe');
        }
        return $this->getData('za_osobe') . ' (współmałżonek)';
	}

    public function getDate() {
        return $this->getData('data_zgloszenia');
    }
	
    public function getLabel()
    {
        return 'Wpis w rejestrze korzyści';
    }
    
    public function hasHighlights()
    {
        return false;
    }

}