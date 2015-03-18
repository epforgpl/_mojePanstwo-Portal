<?

namespace MP\Lib;

class Rady_gmin_wystapienia extends DataObject
{
	
	protected $tiny_label = 'Wystąpienie';
	
	protected $schema = array(
		array('krakow_posiedzenia_punkty.tytul', 'Debata', 'string', array(
			'link' => array(
				'dataset' => 'krakow_posiedzenia_punkty',
				'object_id' => '$krakow_posiedzenia_punkty.id',
			),
		)),
		array('radni_gmin.nazwa', 'Radny'),
		array('krakow_posiedzenia.numer', 'Numer posiedzenia', 'string', array(
			'link' => array(
				'dataset' => 'krakow_posiedzenia',
				'object_id' => '$krakow_posiedzenia.id',
			),
		)),
		array('rady_gmin_posiedzenia.data', 'Data', 'date')
	);
	
    protected $routes = array(
        'title' => 'radni_gmin.nazwa',
        'shortTitle' => 'radni_gmin.nazwa',
        'date' => 'krakow_posiedzenia.data',
    );

	protected $hl_fields = array(
		'krakow_posiedzenia_punkty.tytul'
	);
	
    public function getThumbnailUrl($size = '3')
    {
        return 'http://img.youtube.com/vi/' . $this->getData('krakow_posiedzenia_punkty.yt_video_id') . '/mqdefault.jpg';
    }

    public function getLabel()
    {
        return 'Mówca: <strong>' . $this->getData('mowca_str') . '</strong>';
    }

    public function getUrl()
    {
        return '/dane/gminy/903/punkty/' . $this->getData('punkt_id') . '#' . $this->getId();
    }

}