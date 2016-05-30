<p class="header-a">
    <a href="/dane/fb_accounts/<?= $object->getData('fb_accounts.id') ?>"><strong><?= $object->getData('fb_accounts.name') ?></strong></a>
        <span class="label label-<?= $object->getAccountTypeClass() ?>"><?= $object->getAccountTypeName() ?></span>
    <span class="date"><?= $this->Czas->dataSlownie($object->getData('created_time'), array(
    	'relativeMode' => 2,
    	'seconds' => false,
    )) ?></span>
</p>



<? if( $object->getOptions('page') ) { ?>

    <? if( $message = $object->getData('message') ) { ?>
    <blockquote class="_"><?= strip_tags($message) ?></blockquote>
    <? } ?>

    <? if ($object->getData('picture')) { ?>
	    <img class="media" src="<?= $object->getData('picture') ?>" onerror="imgFixer(this)" />
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