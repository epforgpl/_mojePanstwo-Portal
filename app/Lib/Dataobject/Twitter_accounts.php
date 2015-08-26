<?

namespace MP\Lib;

class Twitter_accounts extends DataObject
{
	
	protected $tiny_label = 'Konto Twitter';
	
    protected $schema = array(
		array('liczba_tweetow', 'Liczba tweetów', 'integer'),
		array('liczba_retweetow_wlasnych', 'Liczba retweetów', 'integer'),
		array('liczba_wzmianek_rts', 'Liczba wzmianek', 'integer'),
		array('liczba_odpowiedzi_rts', 'Liczba odpowiedzi', 'integer'),
		array('liczba_obserwujacych', 'Liczba obserwujacych', 'integer'),
		array('liczba_tweetow_wlasnych_2013', 'Liczba tweetów w 2013 r.', 'integer'),
		array('liczba_wzmianek_rts_2013', 'Liczba wzmianek w 2013 r.', 'integer'),
		array('liczba_odpowiedzi_rts_2013', 'Liczba odpowiedzi w 2013 r.', 'integer'),
		array('liczba_retweetow_wlasnych_2013', 'Liczba retweetów w 2013 r.', 'integer'),
	);
	
	protected $routes = array(
	    'title' => 'name',
        'shortTitle' => 'name',
	);
	
	protected $hl_fields = array(
		'liczba_tweetow', 'liczba_retweetow_wlasnych', 'liczba_wzmianek_rts', 'liczba_odpowiedzi_rts', 'liczba_obserwujacych',
	);

    public function getShortTitle()
    {
        return $this->getData('name') . ' <span class="small text-muted">(@' . $this->getData('twitter_name') . ')</span>';
    }

    public function getLabel()
    {
        return 'Konto na Twitterze';
    }
	
	public function getDescription()
	{
		return $this->getData('description');
	}
	
    public function getThumbnailUrl($size = false)
    {
        $url = $this->getData('profile_image_url_https');
        return str_replace('normal', 'bigger', $url);
    }

    public function hasHighlights()
    {
        return false;
    }
} 