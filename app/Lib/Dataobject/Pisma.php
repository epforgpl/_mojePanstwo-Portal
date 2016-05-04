<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Pisma extends DataObject
{

    protected $routes = array(
        'title' => 'name',
        'shortTitle' => 'name',
        'date' => 'date',
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
	    return 'http://pisma.sds.tiktalik.com/thumbs/' . $this->getData('hash') . '-big.png';
    }

    public function getDescription()
    {
	    return null;
    }

    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		if( $this->getDate() )
			$output[] = dataSlownie( $this->getDate() );
				
		
		if( $this->getData('template_label') )
			$o = $this->getData('template_label');
		
		$output[] = $o;

		return $output;
	}

	public function getDefaultColumnsSizes() {
	    return array(4, 8);
    }

	public function getSlug() {
		return '';
	}

}
