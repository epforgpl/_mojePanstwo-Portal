<?

namespace MP\Lib;

class Fb_posts extends DataObject
{
	
	protected $tiny_label = 'Post';
	
	protected $hl_fields = array(
    	'twitter_accounts.name', 'liczba_retweetow',
    );
    
    public $dictionary = array(
		2 => array('Komentator', 'primary'),
		3 => array('Urząd', 'warning'),
		7 => array('Polityk', 'danger'),
		9 => array('NGO', 'success'),
	);
	
	public function getAccountTypeName(){
		$output = '';
				
		if( 
			( $type_id = $this->getData('fb_accounts.type_id') ) && 
			( in_array($type_id, array_keys($this->dictionary)) )
		) {
			
			$output = $this->dictionary[ $type_id ][0];
			
		}
		
		return $output;	
		
	}
	
	public function getAccountTypeClass(){
				
		$output = '';
		
		if( 
			( $type_id = $this->getData('fb_accounts.type_id') ) && 
			( in_array($type_id, array_keys($this->dictionary)) )
		) {
			
			$output = $this->dictionary[ $type_id ][1];
			
		}
		
		return $output;	
		
	}
	
    public function getShortTitle()
    {
        return false;
    }


    public function getThumbnailUrl($size = false)
    {
	    	    
        $url = $this->getData('fb_accounts.picture');
        if (!$url)
            $url = $this->getData('fb_accounts.picture');

        return $url;
    }

    public function hasHighlights()
    {
        return false;
    }
	
	public function getFullLabel()
	{
		return $this->getLabel() . ' z ' . dataSlownie( $this->getTime() );
	}

} 