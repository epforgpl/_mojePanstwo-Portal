<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Dzialania extends DataObject
{

	protected $tiny_label = 'Działania';

    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'desc' => false,
    );

    public function getLabel()
    {
        return 'Działanie';
    }
	
	public function getShortTitle() {
		return $this->getData('tytul') ? $this->getData('tytul') : 'Działanie';
	}
	
	public function getTitleAddon() {
		if($this->getData('status') == '0') {
			return 'Brudnopis';
		}

		return false;
	}

	public function getUrl()
	{
		return '/dane/' . $this->getData('dataset') . '/' . $this->getData('object_id') . '/dzialania/' . $this->getId();
	}

	public function getThumbnailUrl($size = '2')
    {
	    if( $this->getData('photo') )
	        return 'http://sds.tiktalik.com/portal/' . $size . '/pages/dzialania/' . $this->getId() . '.jpg';
	    else
	    	return false;
    }

    public function getDescription()
    {
	    return $this->getData('podsumowanie');
    }

    public function getMetaDescriptionParts($preset = false)
	{

		$output = array();

		if( $this->getData('data_utworzenia') )
			$output[] = dataSlownie($this->getData('data_utworzenia'));

		return $output;

	}

	public function getDefaultColumnsSizes() {
	    return array(4, 8);
    }

}
