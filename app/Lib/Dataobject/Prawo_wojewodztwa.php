<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Prawo_wojewodztwa extends DocDataObject
{

    public $force_hl_fields = true;
    protected $tiny_label = 'Akt prawny';
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul_skrocony',
        'date' => 'data_wydania',
        'label' => 'label',
        'description' => 'opis',
    );

    public function getLabel()
    {
        $output = $this->getData('forma_str');
        $output .= ' - <strong>' . $this->getData('organ_wydajacy_str') . '</strong>';
        return $output;
    }

    public function getMetaDescriptionParts($preset = false)
    {
        return array(
            dataSlownie($this->getDate()),
        );

    }

}