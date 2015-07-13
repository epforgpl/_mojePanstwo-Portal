<?

namespace MP\Lib;

class Urzedy_gmin extends DataObject
{
	
	protected $tiny_label = 'Urząd gminy';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'label' => 'typ_nazwa',
    );
	
	public function getLabel() {
		return 'Urząd gminy';
	}
	
	public function getShortTitle() {
		return $this->getData('nazwa');
	}
	
	public function getUrl() {
		return '/dane/gminy/' . $this->getData('id') . ',krakow/urzad';
	}

}