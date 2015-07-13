<?

namespace MP\Lib;

class Sejm_posiedzenia_punkty extends DataObject
{
	
	protected $tiny_label = 'Sejm';
	
	protected $schema = array(
		array('sejm_posiedzenia.tytul', 'Posiedzenie', 'string', array(
			'link' => array(
				'dataset' => 'sejm_posiedzenia',
				'object_id' => '$sejm_posiedzenia.id',
			),
		)),
		array('liczba_debat', 'Liczba debat', 'integer'),
		array('liczba_wystapien', 'Liczba wystąpień', 'integer'),
		array('liczba_glosowan', 'Liczba głosowań', 'integer'),
		array('numer', 'Numer punktu'),
	);
		
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data',
    );
    
    protected $hl_fields = array(
    	'sejm_posiedzenia.tytul', 'liczba_wystapien', 'liczba_glosowan',
    );

    public function getLabel()
    {
        return '<strong>Punkt #' . $this->getData('numer') . '</strong> porządku dziennego w Sejmie';
    }


}