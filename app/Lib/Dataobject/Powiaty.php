<?

namespace MP\Lib;

class Powiaty extends DataObject
{

    protected $tiny_label = 'Powiat';

    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Powiat';
    }

    public function getIcon()
    {
        return '<i class="object-icon glyphicon" data-icon-datasets="&#xe626;"></i>';
    }

    public function hasHighlights()
    {
        return false;
    }

}