<?

namespace MP\Lib;

class Radni_gmin extends DataObject
{
	
	protected $tiny_label = 'Radny gminy';
	
	protected $schema = array(
		array('gminy.nazwa', 'Gmina', 'string', array(
			'link' => array(
				'dataset' => 'gminy',
				'object_id' => '$gminy.id',
			),
		)),
		
		array('oswiadczenie_id', 'Powiązania ze służbami PRL', 'string', array(
			'dictionary' => array(
				'1' => 'Praca',
				'2' => 'Służba',
				'3' => 'Współpraca',
				'4' => 'Brak danych',
			),
		)),

		array('komitet', 'Komitet wyborczy'),
		array('poparcie', 'Poparcie', 'string'),
		array('rady_gmin_okregi.nr_okregu', 'Numer okręgu', 'integer'),

		array('numer_listy', 'Numer listy', 'string'),
		array('pozycja', 'Pozycja na liście', 'integer'),

		array('liczba_glosow', 'Liczba głosów', 'integer'),
		array('procent_glosow_w_okregu', 'Popracie w okręgu', 'percent'),

		array('miejsce_zamieszkania', 'Miejsce zamieszkania', 'string'),
		array('obywatelstwo', 'Obywatelstwo', 'string'),
	);	
	
	
	
	
	
	
    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );
    
    protected $hl_fields = array(
    	'gminy.nazwa', 'komitet'
    );

    public function getLabel()
    {
        $output = $this->getShortLabel();
        $output .= ' <a href="/dane/gminy/' . $this->getData('gmina_id') . '">' . $this->getData('gminy.nazwa') . '</a>';
        return $output;
    }
    
    public function getShortLabel()
    {
        $output = ($this->getData('plec') == 'K') ? 'Radna' : 'Radny';
        return $output . ' gminy';
    }
    
    public function hasHighlights()
    {
        return false;
    }
    
    public function getUrl()
    {
	    return '/dane/gminy/' . $this->getData('gmina_id') . '/radni/' . $this->getId();
    }
    
    public function getThumbnailUrl($size = '0')
    {
    	if( $this->getData('avatar')=='1' )
    		return 'https://s3.eu-central-1.amazonaws.com/epf.cdn/avatars/5/' . $this->getData('avatar_id') . '.jpg';
	    elseif( $this->getData('plec')=='K' )
    		return 'https://s3.eu-central-1.amazonaws.com/epf.cdn/avatars/w.png';
	    else 
    		return 'https://s3.eu-central-1.amazonaws.com/epf.cdn/avatars/m.png';
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
			switch ($this->getData('komitet')){
                case 'KWW Jacka Majchrowskiego':
                    $klub='Klub Radnych Przyjazny Kraków';
                    break;
                case 'KWW JACKA MAJCHROWSKIEGO':
                    $klub='Klub Radnych Przyjazny Kraków';
                    break;
                case 'KW Platforma Obywatelska RP':
                    $klub='Klub Radnych Platformy Obywatelskiej';
                    break;
                case 'KW Prawo i Sprawiedliwość':
                    $klub='Klub Radnych Prawa i Sprawiedliwości';
                    break;
                default:
                    $klub=$this->getData('komitet');
            };

        if(false!==strpos($_SERVER['REQUEST_URI'],$this->getId())){
            $output = array(
                $klub,
                $this->getData('komitet')
            );
        }else {
            $output = array(
                $klub,
            );
        }
		return $output;
		
	}
	
	public function getBreadcrumbs() {
		return array(
			array(
				'id' => '/dane/gminy/' . $this->getData('gmina_id') . '/rada',
				'label' => 'Radni gminy',
			),
		);
	}

}