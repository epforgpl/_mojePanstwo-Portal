<?

namespace MP\Lib;

class Poslowie_wyjazdy extends DataObject
{
	
	protected $tiny_label = 'Poseł';
	
    protected $schema = array(
		array('poslowie_wyjazdy_wydarzenia.lokalizacja', '', 'string'),
		array('wartosc_koszt', 'Koszt wyjazdu', 'pln'),	);
    
    
    protected $hl_fields = array(
    	'poslowie_wyjazdy_wydarzenia.lokalizacja', 'wartosc_koszt'
    );
	
    public function getLabel()
    {
        return 'Wyjazd zagraniczny posła';
    }
    
    public function getDate()
    {
        return $this->getData('poslowie_wyjazdy_wydarzenia.data_start');
    }
    
    public function getShortTitle(){
	    
	    return '<a href="/dane/poslowie/' . $this->getData('poslowie.id') . '">' . $this->getData('poslowie.nazwa') . '</a> <br/> <small><a href="/dane/poslowie_wyjazdy_wydarzenia/' . $this->getData('poslowie_wyjazdy_wydarzenia.id') . '">' . $this->getData('poslowie_wyjazdy_wydarzenia.delegacja') . '</a></small>';
	    
    }
    
    public function getTitle(){
	    
	    return 'Wyjazd ' . $this->getData('poslowie.dopelniacz') . ' na wydarzenie: ' . $this->getData('poslowie_wyjazdy_wydarzenia.delegacja');
	    
    }

    public function getThumbnailUrl($size = '5')
    {
        return 'http://resources.sejmometr.pl/mowcy/a/' . '5' . '/' . $this->getData('ludzie_poslowie.mowca_id') . '.jpg';
    }
    
    public function getUrl(){
	    return false;
    }


}