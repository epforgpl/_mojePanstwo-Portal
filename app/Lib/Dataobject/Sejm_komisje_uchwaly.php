<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_komisje_uchwaly extends DocDataObject
{
	
	protected $tiny_label = 'Sejm';
	
	protected $schema = array(
		array('poslowie.nazwa', 'Ukarany poseł', 'string', array(
			'link' => array(
				'dataset' => 'poslowie',
				'object_id' => '$poslowie.id',
			),
			'img' => 'http://resources.sejmometr.pl/mowcy/a/3/{$ludzie_poslowie.mowca_id}.jpg',
		)),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'date',
        'label' => 'label'
    );
    
    protected $hl_fields = array(
    	'poslowie.nazwa'
    );

    public function getLabel()
    {
        return '<strong>Uchwała</strong> ' . $this->getData('sejm_komisje.dopelniacz');
    }

    public $force_hl_fields = true;

    public function getUrl() {

        return '/dane/instytucje/3214/komisje_uchwaly/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {

        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/komisje_uchwaly',
                'label' => 'Uchwały komisji sejmowych',
            ),
        );

    }
}