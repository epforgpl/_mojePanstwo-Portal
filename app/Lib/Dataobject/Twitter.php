<?

namespace MP\Lib;

class Twitter extends DataObject
{
	
	protected $tiny_label = 'Tweet';
	
	protected $schema = array(
		array('czas_utworzenia', 'Data publikacji', 'datetime'),
		array('html', 'Treść', 'string'),
		array('twitter_accounts.name', 'Autor', 'string', array(
			'link' => array(
				'dataset' => 'twitter_accounts',
				'object_id' => '$twitter_accounts.id',
			),
		)),
		array('liczba_retweetow', 'Liczba retweet\'ów', 'integer'),
		array('liczba_odpowiedzi', 'Liczba odpowiedzi', 'integer'),
	);
	
    protected $routes = array(
        'date' => 'czas_utworzenia',
        'time' => 'czas_utworzenia',
        'title' => 'html',
    );
	
	protected $hl_fields = array(
    	'twitter_accounts.name', 'liczba_retweetow',
    );
    
    public $dictionary = array(
		2 => array('Komentator', 'primary'),
		3 => array('Urząd', 'warning'),
		7 => array('Polityk', 'danger'),
		9 => array('NGO', 'success'),
		10 => array('Miasto', 'warning'),
		6 => array('Media', 'primary'),
		8 => array('Partia', 'danger'),
	);
	
	public function getAccountTypeName(){
		$output = '';
				
		if( 
			( $type_id = $this->getData('twitter_accounts.typ_id') ) && 
			( in_array($type_id, array_keys($this->dictionary)) )
		) {
			
			$output = $this->dictionary[ $type_id ][0];
			
		}
		
		return $output;	
		
	}
	
	public function getAccountTypeClass(){
				
		$output = '';
		
		if( 
			( $type_id = $this->getData('twitter_accounts.typ_id') ) && 
			( in_array($type_id, array_keys($this->dictionary)) )
		) {
			
			$output = $this->dictionary[ $type_id ][1];
			
		}
		
		return $output;	
		
	}
		
    public function getLabel()
    {
    	/*
        $output = '<strong>';
        $output .= ($this->getData('usuniety') == '1') ? 'Usunięty tweet' : 'Tweet';
        $output .= '</strong>';


        $account_name = $this->getData('twitter_user_name');
        $account_href = 'https://twitter.com/' . $this->getData('twitter_user_screenname');
        if ($this->getData('twitter_accounts.id')) {
            $account_name = $this->getData('twitter_accounts.name');
            $account_href = '/dane/twitter_accounts/' . $this->getData('twitter_accounts.id');
        }


        $output .= ' od <a href="' . $account_href . '">' . $account_name . '</a>';

        return $output;
        */
                
        return 'Tweet od <a href="/dane/twitter_accounts/' . $this->getData('twitter_accounts.id') . '">' . $this->getData('twitter_accounts.name') . '</a>';
    }
	
	public function getData($field = '*')
    {
    	if( $field=='twitter_accounts.id' && empty($this->data['twitter_accounts.id']) )	    
	    	return @$this->getData('twitter_user_id');
	    elseif( $field=='twitter_accounts.name' && empty($this->data['twitter_accounts.name']) )	    
	    	return @$this->getData('twitter_user_name');
	    	
    	return parent::getData( $field );        
    }
	
    public function getShortTitle()
    {
        return false;
    }


    public function getThumbnailUrl($size = false)
    {
        $url = $this->getData('twitter_user_avatar_url');
        if (!$url)
            $url = $this->getData('twitter_accounts.profile_image_url');

        return str_replace('normal', 'bigger', $url);
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