<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Senat_rejestr_korzysci extends DocDataObject
{
	
	protected $tiny_label = 'Rejestr korzyści';
	
    public function getTitle()
    {
        return 'Wpis w rejestrze korzyści senatora ' . $this->getData('senatorowie.nazwa');
    }

    public function getShortTitle()
    {
        return ucfirst($this->getData('nazwa'));
    }

    public function getLabel()
    {
        return 'Wpis w rejestrze korzyści senatora';
    }

}