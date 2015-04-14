<?

namespace MP\Lib;

class Poslowie_glosy extends DataObject
{
	
	protected $tiny_label = 'Głos';
	
	protected $schema = array(
		array('sejm_glosowania.czas', 'Data', 'date', array(
			'noHl' => true,
		)),
		array('poslowie.nazwa', 'Poseł', 'string'),
		array('glos_id', 'Głos', 'vote'),
	);
	
    protected $routes = array(
        'date' => 'sejm_glosowania.czas',
        'shortTitle' => 'sejm_glosowania.tytul',
    );
    
    public $hl_fields = array(
		'poslowie.nazwa', 'glos_id'
	);

    public function getLabel()
    {
        return 'Wynik głosowania posła';
    }

    public function getTitle()
    {
        return 'Wynik głosowania posła ' . $this->getData('poslowie.nazwa') . ' w głosowaniu: ' . $this->getData('sejm_glosowania.tytul');
    }

}