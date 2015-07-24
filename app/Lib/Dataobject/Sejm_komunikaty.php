<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_komunikaty extends DocDataObject
{
	
	protected $tiny_label = 'Sejm';
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'date',
    );

    public function getLabel()
    {
        return 'Komunikat Kancelarii Sejmu';
    }

    public function getThumbnailUrl($size = false)
    {
        return ($this->getData('img') == '1') ?
            'http://resources.sejmometr.pl/sejm_komunikaty/img/' . $this->getId() . '-1.jpg' : false;
    }

    public function getUrl() {

        return '/dane/instytucje/3214/komunikaty/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {
        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/komunikaty',
                'label' => 'Komunikaty Kancelarii Sejmu',
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