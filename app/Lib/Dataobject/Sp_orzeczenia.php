<?

namespace MP\Lib;

class Sp_orzeczenia extends DataObject
{

    public $force_hl_fields = true;
    protected $tiny_label = 'Orzeczenie sądu';
    protected $schema = array(
        array('wydzial', 'Wydział'),
        array('podstawa_prawna', 'Podstawa prawna'),
        array('hasla_tematyczne', 'Hasła tematyczne'),
    );
    protected $routes = array(
        'shortTitle' => 'sygnatura',
        'date' => 'data',
    );
    protected $hl_fields = array(
        'wydzial', 'hasla_tematyczne'
    );

    public function getLabel()
    {

        return '<strong>Orzeczenie</strong> ' . $this->getData('dopelniacz') . ' z dnia ' . dataSlownie($this->getDate());

    }

    public function getTitle()
    {
		
        return $this->getShortTitle() . ' - orzeczenie ' . $this->getData('dopelniacz') . ' z dnia ' . dataSlownie($this->getDate());

    }

}