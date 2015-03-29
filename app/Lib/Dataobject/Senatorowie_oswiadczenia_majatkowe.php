<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Senatorowie_oswiadczenia_majatkowe extends DocDataObject
{
	
	protected $tiny_label = 'Oświadczenia majątkowe';
	
    public function getTitle()
    {
        return 'Oświadczenie majątkowe senatora ' . $this->getData('senatorowie.nazwa');
    }

    public function getShortTitle()
    {
        return ucfirst($this->getData('nazwa'));
    }

    public function getLabel()
    {
        return 'Oświadczenie majątkowe senatora';
    }
    
    public function hasHighlights()
    {
        return false;
    }
	
	public function getMetaDate()
	{
		return $this->getDate();
	}
	
}