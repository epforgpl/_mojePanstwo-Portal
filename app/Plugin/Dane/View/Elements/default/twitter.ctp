
<p class="header-a">
    <? if ($object->getData('twitter_account_id')) { ?>
        <a href="/dane/twitter_accounts/<?= $object->getData('twitter_account_id') ?>"><strong><?= $object->getData('twitter_accounts.name') ?></strong></a>
        <span class="label label-<?= $object->getAccountTypeClass() ?>"><?= $object->getAccountTypeName() ?></span>
    <? } else { ?>
        <a target="_blank"
           href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>"><strong><?= $object->getData('twitter_user_name') ?></strong></a>
    <? } ?>
    <span class="date"><?= $this->Czas->dataSlownie($object->getData('twitter.czas_utworzenia'), array(
    	'relativeMode' => 2,
    	'seconds' => false,
    )) ?></span>
</p>


<? if( $object->getData('usuniety') ) {?>
<div class="alert alert-danger">
	<p>Tweet został usunięty</p>
</div>
<? } ?>

<? if( $object->getOptions('page') ) { ?>

    <blockquote class="_"><?= $object->getData('html') ?></blockquote>

    <? if ($object->getData('photo_url')) { ?>
	    <img class="media" src="<?= $object->getData('photo_url') ?>" onerror="imgFixer(this)" />
	<? } ?>

<? } else { ?>

<a href="/dane/twitter/<?= $object->getId() ?>">

    <blockquote class="_"><?= strip_tags($object->getData('html')) ?></blockquote>

    <? if ($object->getData('photo_url')) { ?>
	    <img class="media" src="<?= $object->getData('photo_url') ?>" onerror="imgFixer(this)" />
	<? } ?>

</a>

<? } ?>


<? if ($object->getData('twitter_account_id')) { ?>
    <div class="tweet_stats">

        <p class="_counter" title="Liczba retweetów"><span
                    class="glyphicon glyphicon-retweet"></span> <?= number_format($object->getData('liczba_retweetow'), 0, '.', ' ') ?></p>

        <p class="_counter" title="Liczba ulubionych"><span
                    class="glyphicon glyphicon-heart"></span> <?= number_format($object->getData('liczba_ulubionych'), 0, '.', ' ') ?></p>

        <p class="_counter" title="Liczba odpowiedzi"><span
                    class="glyphicon glyphicon-comment"></span> <?= $object->getData('liczba_odpowiedzi') ?>
            </p>

    </div>
<? } ?>

<? if( $object->getOptions('page') ) { ?>
<p class="_src margin-top-20"><a title="Źródło" target="_blank"
                               href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>/statuses/<?= $object->getData('src_id') ?>"><span
                    class="glyphicon glyphicon-new-window"></span> Źródło</a></p>
<? } ?>
