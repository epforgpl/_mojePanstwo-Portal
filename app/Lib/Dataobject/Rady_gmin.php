<?

namespace MP\Lib;

class Rady_gmin extends DataObject
{
	
	protected $tiny_label = 'Rada gminy';
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
        'label' => 'typ_nazwa',
    );
	
	public function getLabel() {
		return 'Rada gminy';
	}
	
	public function getShortTitle() {
		return 'Rada Miasta ' . $this->getData('nazwa');
	}
	
	public function getUrl() {
		return '/dane/gminy/' . $this->getData('id') . ',krakow/rada';
	}

}