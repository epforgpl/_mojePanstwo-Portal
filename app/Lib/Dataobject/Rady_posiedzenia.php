<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Rady_posiedzenia extends DocDataObject
{
	protected $tiny_label = 'Samorząd';
	
	protected $schema = array(
		array('numer', 'Numer posiedzenia'),
		array('gminy.rada_nazwa', 'Rada', 'string', array(
			'link' => array(
				'dataset' => 'gminy',
				'object_id' => '$gmina_id',
			),
		)),
		array('liczba_debat', 'Liczba debat', 'integer'),
	);
	
    protected $routes = array(
        'title' => 'fullTitle',
        'shortTitle' => 'dateStr',
        'date' => 'data',
    );
    
    protected $hl_fields = array(
    	'gminy.rada_nazwa', 'numer', 'liczba_debat',
    );
	
	public function __construct($params = array())
    {

        parent::__construct($params);

        $this->data['fullTitle'] = 'Posiedzenie <strong>#' . $this->getData('numer') . '</strong> ' . $this->getData('gminy.rada_nazwa_dopelniacz');
        $this->data['pageTitle'] = 'Posiedzenie #' . $this->getData('numer') . ' Rady Miasta';
        $this->data['dateStr'] = $this->dataSlownie($this->getDate());

    }
	
    public function getLabel()
    {
        return 'Posiedzenie rady gminy';
    }

    public function getThumbnailUrl($size = '3')
    {
        return 'http://img.youtube.com/vi/' . $this->getData('preview_yt_id') . '/mqdefault.jpg';
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/' . $this->getData('gmina_id') . '/posiedzenia/' . $this->getId();
    }

}