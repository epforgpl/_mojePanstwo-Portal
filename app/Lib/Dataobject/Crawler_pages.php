<?

namespace MP\Lib;

class Crawler_pages extends DataObject
{
	
	protected $tiny_label = 'Strona';
	
	protected $schema = array(
		array('liczba_rozmiar', 'Rozmiar', 'integer', array(
			'format' => 'bytes',
		)),
		array('content_type', 'Typ'),
		array('crawler_sites.nazwa', 'Portal', 'string', array(
			'link' => array(
				'dataset' => 'crawler_sites',
				'object_id' => '$site_id',
			),
		)),
		array('url', 'URL', 'string', array(
			'truncate' => 70,
			'link' => array(
				'href' => '$url',
				'newWindow' => true,
			),
		)),
	);
	
    protected $routes = array(
        'title' => 'title',
        'shortTitle' => 'title',
        'date' => 'data_utworzenia',
        'label' => 'crawler_sites.nazwa'
    );
    
    protected $hl_fields = array(
    	'liczba_rozmiar', 'content_type'
    );
    
    public function getThumbnailUrl( $size = 0 )
    {
	    return 'http://crawler.sds.tiktalik.com/thumbnail/' . $this->getId() . '.jpg';
    }
    
    public $force_hl_fields = true;

}