<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Msig_dzialy extends DocDataObject
{
	
	protected $tiny_label = 'MSiG Dział';
	
    protected $routes = array(
        'date' => 'msig.data',
    );

    public function getLabel()
    {
        return 'Dział w Monitorze Sądowym i Gospodarczym';
    }

    public function getShortTitle()
    {
        return $this->getData('nazwa');
    }

    public function getTitle()
    {
        return $this->getData('nazwa') . ' - MSiG z dnia ' . $this->dataSlownie( $this->getData('msig.data') );
    }

}