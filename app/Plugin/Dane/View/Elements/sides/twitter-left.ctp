<?
	
	/*
	'twitter.in_reply_to_tweet_id' => '0',
	'twitter_accounts.name' => 'Adam S Jasser',
	'twitter.twitter_account_type_id' => '7',
	'twitter.konto_obserwowane' => '1',
	'twitter.liczba_retweetow' => (int) 0,
	'twitter_accounts.twitter_id' => '413198806',
	'twitter.html' => '<a rel="nofollow" target="_blank" href="http://www.twitter.com/VaGla">@VaGla</a> czyli znowu nie chodzi Panu o dostęp do informacji publicznej, tylko ma Pan przekonanie, że będąc na TT łamiemy naszą ustawę.',
	'twitter.source_id' => '6',
	'twitter.id' => '11085798',
	'twitter.retweeted_account_id' => '0',
	'twitter_accounts.typ_id' => '7',
	'twitter.twitter_account_id' => '520',
	'twitter.usuniety' => '0',
	'twitter.in_reply_to_account_type_id' => '2',
	'twitter.in_reply_to_account_id' => '152',
	'twitter.liczba_symboli' => (int) 0,
	'twitter.liczba_zaangazowan' => (int) 0,
	'twitter.truncated' => '0',
	'twitter_accounts.profile_image_url_https' => 'https://pbs.twimg.com/profile_images/556541256793608194/2NhWGBsp_normal.jpeg',
	'twitter.photo_url' => '',
	'twitter.liczba_odpowiedzi' => (int) 0,
	'twitter.twitter_user_screenname' => 'AdamSJasser',
	'twitter.retweeted_id' => '0',
	'twitter.twitter_user_name' => 'Adam S Jasser',
	'twitter.retweeted_account_type_id' => '0',
	'twitter.retweet' => '0',
	'twitter.czas_utworzenia' => '2015-03-15 21:49:01',
	'twitter.liczba_sekund_do_usuniecia' => (int) 0,
	'twitter.liczba_adresow' => (int) 0,
	'twitter.liczba_wzmianek' => (int) 1,
	'twitter.liczba_odpowiedzi_rts' => (int) 0,
	'twitter.liczba_ulubionych' => (int) 0,
	'twitter.src_id' => '577209909068095488',
	'twitter.liczba_mediow' => (int) 0,
	'twitter_accounts.profile_image_url' => 'http://pbs.twimg.com/profile_images/556541256793608194/2NhWGBsp_normal.jpeg',
	'twitter_accounts.twitter_name' => 'AdamSJasser',
	'twitter.twitter_user_id' => '413198806',
	'twitter.twitter_user_avatar_url' => 'http://pbs.twimg.com/profile_images/577199175848230912/vgbxlIrk_normal.jpeg',
	'twitter.liczba_tagow' => (int) 0,
	'twitter_accounts.id' => '520',
	'in_reply_to_tweet_id' => '0',
	'twitter_account_type_id' => '7',
	'konto_obserwowane' => '1',
	'liczba_retweetow' => (int) 0,
	'html' => '<a rel="nofollow" target="_blank" href="http://www.twitter.com/VaGla">@VaGla</a> czyli znowu nie chodzi Panu o dostęp do informacji publicznej, tylko ma Pan przekonanie, że będąc na TT łamiemy naszą ustawę.',
	'source_id' => '6',
	'id' => '11085798',
	'retweeted_account_id' => '0',
	'twitter_account_id' => '520',
	'usuniety' => '0',
	'in_reply_to_account_type_id' => '2',
	'in_reply_to_account_id' => '152',
	'liczba_symboli' => (int) 0,
	'liczba_zaangazowan' => (int) 0,
	'truncated' => '0',
	'photo_url' => '',
	'liczba_odpowiedzi' => (int) 0,
	'twitter_user_screenname' => 'AdamSJasser',
	'retweeted_id' => '0',
	'twitter_user_name' => 'Adam S Jasser',
	'retweeted_account_type_id' => '0',
	'retweet' => '0',
	'czas_utworzenia' => '2015-03-15 21:49:01',
	'liczba_sekund_do_usuniecia' => (int) 0,
	'liczba_adresow' => (int) 0,
	'liczba_wzmianek' => (int) 1,
	'liczba_odpowiedzi_rts' => (int) 0,
	'liczba_ulubionych' => (int) 0,
	'src_id' => '577209909068095488',
	'liczba_mediow' => (int) 0,
	'twitter_user_id' => '413198806',
	'twitter_user_avatar_url' => 'http://pbs.twimg.com/profile_images/577199175848230912/vgbxlIrk_normal.jpeg',
	'liczba_tagow' => (int) 0
	*/
	
?>
<div class="objectSideInner">
	
	<div class="block">
	
		<ul class="dataHighlights side">

			<li class="dataHighlight">
	            <p class="_label">Wysłano</p>
	
	            <div class="">
	                <p class="_value"><?= dataSlownie($object->getData('czas_utworzenia')) ?></p>
	            </div>
	        </li>
	    
		</ul>
		
	</div>
	        
	<div class="block">
		
		<ul class="dataHighlights side">
	
	        <li class="dataHighlight -block">
	
	            <p id="sources">
		            <a target="_blank" href="https://twitter.com/<?= $object->getData('twitter_accounts.twitter_name') ?>/status/<?= $object->getData('twitter.src_id') ?>">Źródło</a>
	            </p>
	        </li>
						
	        
	        
		</ul>
	</div>
	


</div>