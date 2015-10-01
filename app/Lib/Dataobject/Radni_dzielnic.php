<?

namespace MP\Lib;

class Radni_dzielnic extends DataObject
{

	protected $tiny_label = 'Radny dzielnicy';

	protected $schema = array(
		array('dzielnice.nazwa', 'Dzielnica', 'string', array(
			'link' => array(
				'dataset' => 'dzielnice',
				'object_id' => '$dzielnice.id',
			),
		)),
		array('gminy.nazwa', 'Gmina', 'string', array(
			'link' => array(
				'dataset' => 'gminy',
				'object_id' => '$gminy.id',
			),
		)),
		array('liczba_glosow', 'Liczba głosów', 'integer'),
		array('okreg_numer', 'Okręg wyborczy', 'string'),
		array('okreg_ulice', 'Ulice w okręgu', 'string'),
		array('partia_wspierany_przez', 'Wspierany przez', 'string'),

		array('dyzur', 'Dyżur', 'string'),
		array('tel', 'Telefon', 'string'),
		array('email', 'Email', 'string'),
		array('www', 'Strona WWW', 'string'),
        array('www_dzielnica', 'Radny na stonie WWW dzielnicy', 'string'),

		array('wyksztalcenie', 'Wykształcenie', 'string'),
		array('zawod', 'Zawód', 'string'),
		array('miejsce_pracy', 'Miejsce pracy', 'string'),

		array('kadencja', 'Kadencja', 'string'),
		array('funkcja', 'Funkcja publiczne obecnie', 'string'),
        array('komisje', 'Komisje obecnie', 'string'),
		array('funkcje_publiczne_kiedys', 'Funkcje publiczne w przeszłości', 'string'),
		array('ngo', 'Działalność w NGO', 'string'),

		array('social', 'Aktywność społeczna', 'string'),
		array('sukcesy', 'Sukcesy', 'string'),
	);




    protected $hl_fields = array(
    	'gminy.nazwa', 'dzielnice.nazwa', 'liczba_glosow'
    );


	public function getTitle()
    {
        return $this->getShortTitle();
    }

    public function getShortTitle()
    {
        return $this->getData('nazwisko') . ' ' . $this->getData('imie');
    }

	public function hasHighlights()
    {
        return false;
    }

    public function getLabel()
    {
	    return 'Radny dzielnicy';
    }

    public function getShortLabel()
    {
	    return 'Radny dzielnicy ' . $this->getData('dzielnice.nazwa');
    }

    public function getUrl()
    {
	    return '/dane/gminy/903,krakow/dzielnice/' . $this->getData('dzielnica_id') . '/radni/' . $this->getId();
    }

    public function getDescription()
    {
	    $output = 'Radny dzielnicy <a href="/dane/dzielnice/' . $this->getData('dzielnice.id') . '">' . $this->getData('dzielnice.nazwa') . '</a>.<br/>';



	    if( in_array('7', $this->getData('kadencja_id')) )
	    	$output .= ' Kadencja VII.';

	    if( in_array('6', $this->getData('kadencja_id')) )
	    	$output .= ' Kadencja VI.';

	    return $output;
    }

    public function getBreadcrumbs()
	{

		return array(
			array(
				'id' => '/dane/gminy/903,krakow/dzielnice/' . $this->getData('dzielnice.id'),
				'label' => $this->getData('dzielnice.nazwa'),
			),
			array(
				'id' => '/dane/gminy/903,krakow/dzielnice/' . $this->getData('dzielnice.id') . '/rada_uchwaly',
				'label' => 'Radni dzielnicy',
			),
		);

	}
	
	public function getThumbnailUrl( $size = false ) {
		
		if( $this->getData('avatar') )
			return 'http://resources.sejmometr.pl/radni_dzielnic/img/' . $this->getId() . '.png';
		else
			return false;
		
	}
}
