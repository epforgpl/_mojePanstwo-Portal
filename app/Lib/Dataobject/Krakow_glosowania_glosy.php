<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Krakow_glosowania_glosy extends DocDataObject
{
	
	protected $tiny_label = 'Głos';
	
	protected $schema = array(
		array('druk_id', 'Druk', 'string', array(
			'link' => array(
				'dataset' => 'rady_druki',
				'object_id' => '$druk_id',
			),
		)),
		array('numer_punktu', 'Punkt', 'string'),
		array('opis', 'Temat')
	);
	
    protected $routes = array(
        'title' => 'krakow_posiedzenia_punkty.tytul',
        'shortTitle' => 'krakow_posiedzenia_punkty.tytul',
    );
    
    protected $hl_fields = array();
	
	public function getShortLabel()
    {
        return 'Głos';
    }
	
    public function getLabel()
    {
        return 'Głosowanie na posiedzeniu <strong>' . $this->getData('gminy.rada_nazwa_dopelniacz') . '</strong>';
    }
    
	public function getUrl()
	{
		return '/dane/gminy/903,krakow/glosowania/' . $this->getData('krakow_glosowania.id');
	}
    

    
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
				
		if( $this->getData('krakow_glosowania.data_stop') )
			$output[] = dataSlownie($this->getData('krakow_glosowania.data_stop'));
			
		if( $this->getData('krakow_glosowania.tytul') )
			$output[] = $this->getData('krakow_glosowania.tytul');
		
		return $output;
		
	}

}