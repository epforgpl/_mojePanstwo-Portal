<p class="header-a">
    <a href="/dane/fb_accounts/<?= $object->getData('fb_accounts.id') ?>"><strong><?= $object->getData('fb_accounts.name') ?></strong></a>
        <span class="label label-<?= $object->getAccountTypeClass() ?>"><?= $object->getAccountTypeName() ?></span>
    <span class="date"><?= $this->Czas->dataSlownie($object->getData('created_time'), array(
    	'relativeMode' => 2,
    	'seconds' => false,
    )) ?></span>
</p>



<? if( $object->getOptions('page') ) { ?>

    <blockquote class="_"><?= strip_tags($object->getData('message')) ?></blockquote>

    <? if ($object->getData('photo_url')) { ?>
	    <img class="media" src="<?= $object->getData('photo_url') ?>" onerror="imgFixer(this)" />
	<? } ?>

<? } else { ?>

<a href="/dane/fb_posts/<?= $object->getId() ?>">
	
	<? if( $message = $object->getData('message') ) { ?>
    <blockquote class="_"><?= strip_tags($message) ?></blockquote>
    <? } ?>

    <? if ($object->getData('picture')) { ?>
	    <img class="media" src="<?= $object->getData('picture') ?>" onerror="imgFixer(this)" />
	<? } ?>

</a>

<? } ?>


<div class="tweet_stats margin-top-10">
		
    <p class="_counter" title="Liczba polubień"><span
                class="glyphicon glyphicon-thumbs-up"></span> <?= number_format($object->getData('likes'), 0, '.', ' ') ?></p>

    <p class="_counter" title="Liczba udostępnień"><span
                class="glyphicon glyphicon-share-alt"></span> <?= number_format($object->getData('shares'), 0, '.', ' ') ?></p>

    <p class="_counter" title="Liczba komentarzy"><span
                class="glyphicon glyphicon-comment"></span> <?= $object->getData('comments') ?>
        </p>
        
    <p class="_counter" title="Źródło"><a href="https://www.facebook.com/<?= $object->getData('src_id') ?>" target="_blank"><span
                class="glyphicon glyphicon-link"></span></a>
        </p>

</div>

<? if( $object->getOptions('page') ) { ?>
<p class="_src margin-top-20"><a title="Źródło" target="_blank"
                               href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>/statuses/<?= $object->getData('src_id') ?>"><span
                    class="glyphicon glyphicon-new-window"></span> Źródło</a></p>
<? } ?>
