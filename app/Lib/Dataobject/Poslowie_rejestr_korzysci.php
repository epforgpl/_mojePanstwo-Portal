<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Poslowie_rejestr_korzysci extends DocDataObject
{

    protected $tiny_label = 'Rejestr korzyści';

    protected $routes = array(
        'date' => 'data',
        'shortTitle' => 'label',
    );

    public function getTitle()
    {

        return 'Wpis w rejestrze korzyści posła ' . $this->getData('poslowie.dopelniacz') . ' z dnia ' . $this->dataSlownie($this->getDate());

    }

    public function getShortTitle()
    {
        return 'Wpis w rejestrze korzyści posła ' . $this->getData('poslowie.dopelniacz');
    }

    public function getLabel()
    {

        return 'Wpis w rejestrze korzyści posła';

    }

    public function getUrl()
    {

        return '/dane/instytucje/3214/poslowie_rejestr_korzysci/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {

        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/poslowie_rejestr_korzysci',
                'label' => 'Rejestr korzyści posłów',
            ),
        );

    }
    public function getMetaDescriptionParts($preset = false)
    {

        $output = array();

        if( $this->getDate() )
            $output[] = dataSlownie($this->getDate());

        return $output;

    }
}