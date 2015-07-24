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

    public function getUrl() {

        return '/dane/instytucje/3214/poslowie_oswiadczenia_majatkowe/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {

        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/poslowie_oswiadczenia_majatkowe',
                'label' => 'Oświadczenia majątkowe posłów',
            ),
        );

    }

}