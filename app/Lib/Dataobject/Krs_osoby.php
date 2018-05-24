<?

namespace MP\Lib;

class Krs_osoby extends DataObject
{
	
	public $_pageDescription = false;
    protected $tiny_label = 'Osoba';
	
    protected $schema = array(
        array('powiazania', 'Związany z'),
    );

    protected $hl_fields = array(
        'powiazania',
    );

    public function getIcon()
    {
        $icon = "osoby";

        if ($this->getData('krs_osoby.plec') == 'K')
            $icon .= '_kobieta';
        else
            $icon .= '_mezczyzna';

        return '<span class="object-icon icon-datasets-' . $icon . '"></span>';
    }

    public function getData($field = '*')
    {
        if (($field == 'powiazania') && (preg_match_all('/\<a(.*?)\/a\>/i', $this->getData('str'), $matches))) {
            $items = array();
            for ($i = 0; $i < count($matches[0]); $i++)
                if (!in_array($matches[0][$i], $items))
                    $items[] = $matches[0][$i];
            return $items;
        }

        return parent::getData($field);
    }

    public function getShortTitle()
    {
        return $this->getTitle();
    }

    public function getTitle()
    {
        return $this->getData('imiona') . ' ' . $this->getData('nazwisko');
    }

    public function getLabel()
    {
        return '<strong>Osoba</strong> w Krajowym Rejestrze Sądowym';
    }

    public function getTitleAddon()
    {
	    return false;
        if ($this->data['privacy'] == '1')
            return false;
        else
            return '<span>' . substr($this->data('data_urodzenia'), 0, 4) . '\'</span>';
    }

    public function hasHighlights()
    {
        return false;
    }

    public function getMetaDescriptionParts($preset = false)
    {

        if ($this->getData('krs_osoby.plec') == 'K')
            $str = 'Związana';
        else
            $str = 'Związany';

        $output = array(
            $str . ' z ' . implode(' <span class="sep">-</span> ', $this->getData('powiazania')),
        );

        return $output;

    }
}
