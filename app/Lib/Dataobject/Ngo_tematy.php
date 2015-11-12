<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Ngo_tematy extends DocDataObject
{

    protected $routes = array(
        'title' => 'nazwa',
        'shortTitle' => 'nazwa',
    );

    public function getLabel()
    {
        return 'Temat';
    }

}