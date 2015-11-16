<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Pisma extends DataObject
{

    protected $routes = array(
        'title' => 'name',
        'shortTitle' => 'name',
    );

    public function getLabel()
    {
        return 'Kolekcja';
    }

	public function getUrl()
	{
		if( $this->getOptions('public') )
			return $this->getOptions('base_url') . '/pisma/' . $this->getId();
		else
			return '/dane/pisma/' . $this->getId();
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
	    return null;
    }

    public function getMetaDescriptionParts($preset = false)
	{
		$output = array();
		if( $this->getData('to_label') )
			$output[] = $this->getData('to_label');
		else
			$output[] = 'Brak odbiorcy';

		return $output;
	}

	public function getDefaultColumnsSizes() {
	    return array(4, 8);
    }

	public function getSlug() {
		return '';
	}

}
