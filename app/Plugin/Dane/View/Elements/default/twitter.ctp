<p class="header-a">
    <? if ($object->getData('twitter_account_id')) { ?>
        <a href="/dane/twitter_accounts/<?= $object->getData('twitter_account_id') ?>"><b><?= $object->getData('twitter_accounts.name') ?></b></a>
        <span class="label label-<?= $object->getAccountTypeClass() ?>"><?= $object->getAccountTypeName() ?></span>
    <? } else { ?>
        <a target="_blank"
           href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>"><b><?= $object->getData('twitter_user_name') ?></b></a>
    <? } ?> 
    <span class="date"><?= $this->Czas->dataSlownie($object->getData('twitter.czas_utworzenia'), array(
    	'relativeMode' => 2,
    	'seconds' => false,
    )) ?></span>
</p>

<a href="/dane/twitter/<?= $object->getId() ?>">
    
    <blockquote class="_"><?= strip_tags($object->getData('html')) ?></blockquote>
    
    <? if ($object->getData('photo_url')) { ?>
	    <img class="media" src="<?= $object->getData('photo_url') ?>" onerror="imgFixer(this)" />
	<? } ?>
	
</a>

<? if ($object->getData('twitter_account_id')) { ?>
    <div class="tweet_stats">
        
        <p class="_counter" title="Liczba retweetów"><span
                    class="glyphicon glyphicon-retweet"></span> <?= number_format($object->getData('liczba_retweetow'), 0, '.', ' ') ?></p>
                    
        <p class="_counter" title="Liczba ulubionych"><span
                    class="glyphicon glyphicon-star"></span> <?= number_format($object->getData('liczba_ulubionych'), 0, '.', ' ') ?></p>
            
        <p class="_counter" title="Licza odpowiedzi"><span
                    class="glyphicon glyphicon-comment"></span> <?= $object->getData('liczba_odpowiedzi') ?>
            </p>
        
        <? /* ?> 
        <p class="_counter"><a title="Źródło" target="_blank"
                               href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>/statuses/<?= $object->getData('twitt_id') ?>"><span
                    class="glyphicon glyphicon-new-window"></span> &nbsp;</a></p>
        <? */ ?>
        
    </div>
<? } ?>