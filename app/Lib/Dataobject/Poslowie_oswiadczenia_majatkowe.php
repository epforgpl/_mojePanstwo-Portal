<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Poslowie_oswiadczenia_majatkowe extends DocDataObject
{

    protected $tiny_label = 'Oświadczenie majątkowe';

    protected $routes = array(
        'date' => 'data',
        'shortTitle' => 'label',
    );

    public function getTitle()
    {

        return 'Oświadczenie majątkowe posła ' . $this->getData('poslowie.dopelniacz') . ' z dnia ' . $this->dataSlownie($this->getDate());

    }

    public function getLabel()
    {

        return 'Oświadczenie majątkowe posła';

    }

    public function getIcon()
    {
        return '<i class="object-icon glyphicon" data-icon-datasets="&#xe617;"></i>';
    }

}