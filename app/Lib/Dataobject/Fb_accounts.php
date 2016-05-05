<?

namespace MP\Lib;

class Fb_accounts extends DataObject
{
	
	protected $tiny_label = 'Konto Facebook';    
	
	protected $routes = array(
	    'title' => 'name',
        'shortTitle' => 'name',
	);

    public function getLabel()
    {
        return 'Konto Facebook';
    }
	
	public function getDescription()
	{
		return $this->getData('about');
	}
	
    public function getThumbnailUrl($size = false)
    {
        return $this->getData('picture');
    }
	
	public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
				
		if( $this->getData('likes') )
			$output[] = pl_dopelniacz($this->getData('likes'), 'polubienie', 'polubienia', 'polubień');
												
        return $output;

    }
	
} 