<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_posiedzenia extends DataObject
{

	protected $tiny_label = 'Samorząd';

	protected $schema = array(
		array('numer', 'Numer posiedzenia'),
	);

    protected $routes = array(
        'title' => 'data',
        'shortTitle' => 'data',
        'date' => 'data',
        'description' => 'desc',
    );

    /*
    protected $hl_fields = array(
    	'gminy.rada_nazwa', 'numer', 'liczba_debat',
    );
    */


    public function getMetaDescriptionParts($preset = false)
	{

        $output = array(
			'Kadencja ' . $this->getData('kadencja_id'),
			'Sesja ' . $this->getData('krakow_sesje.str_numer'),
		);

        return $output;

    }

    public function getLabel()
    {
        return 'Posiedzenie Rady Miasta Kraków';
    }

    public function getThumbnailUrl($size = '3')
    {
    	if( $this->getData('preview_yt_id') )
	        return 'http://img.youtube.com/vi/' . $this->getData('preview_yt_id') . '/mqdefault.jpg';
	    else
            return '/dane/img/customObject/krakow/posiedzenie.jpg';
    }

    public function getUrl()
    {
	    return '/dane/gminy/903/posiedzenia/' . $this->getId();
    }

    public function getShortLabel() {

        return 'Posiedzenie Rady Miasta';

    }

    public function getTitle() {
	    return $this->getShortTitle() . ' - Posiedzenie Rady Miasta Kraków';
    }

    public function getShortTitle()
    {
        return dataSlownie($this->getDate());
    }

    public function getBreadcrumbs()
	{

        return array(
			array(
				'id' => '/dane/gminy/903,krakow/posiedzenia',
				'label' => 'Posiedzenia Rady Miasta',
			),
		);

    }

}
