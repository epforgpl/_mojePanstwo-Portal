<p class="header-a">
    <? if ($object->getData('twitter_account_id')) { ?>
        <a href="/dane/twitter_accounts/<?= $object->getData('twitter_account_id') ?>"><b><?= $object->getData('twitter_accounts.name') ?></b></a>
        <span class="label label-<?= $object->getAccountTypeClass() ?>"><?= $object->getAccountTypeName() ?></span>
    <? } else { ?>
        <a target="_blank"
           href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>"><b><?= $object->getData('twitter_user_name') ?></b></a>
    <? } ?>
</p>

<p class="meta meta-date"><?= $object->getData('twitter.czas_utworzenia') ?></p>

<blockquote class="_">
    <?= $object->getData('html') ?>
</blockquote>

<? if ($object->getData('photo_url')) { ?>
    <img style="max-width: 400px; margin-top: 10px; float: left;" src="<?= $object->getData('photo_url') ?>"
         onerror="imgFixer(this)"/>
<? } ?>

<? if ($object->getData('twitter_account_id')) { ?>
    <div class="tweet_stats">
        <div class="row">
            <div class="col-lg-2">


                <p class="_counter"><a title="Liczba retweetów" href="/dane/twitter/<?= $object->getId() ?>"><span
                            class="glyphicon glyphicon-retweet"></span> <?= number_format($object->getData('liczba_retweetow'), 0, '.', ' ') ?>
                    </a></p>

                <? /*<p class="_label"><?= __d('media', 'LC_PANSTWOINTERNET_RETWEET') ?></p> */ ?>

            </div>
            <div class="col-lg-2">

                <p class="_counter"><a title="Licza odpowiedzi" href="/dane/twitter/<?= $object->getId() ?>"><span
                            class="glyphicon glyphicon-transfer"></span> <?= $object->getData('liczba_odpowiedzi') ?>
                    </a></p>

                <? /*<p class="_label"><?= __d('media', 'LC_PANSTWOINTERNET_ODPOWIEDZI') ?></p> */ ?>

            </div>
            <div class="col-lg-2">

                <p class="_counter"><a title="Źródło" target="_blank"
                                       href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>/statuses/<?= $object->getData('twitt_id') ?>"><span
                            class="glyphicon glyphicon-new-window"></span> &nbsp;</a></p>

            </div>
        </div>
    </div>
<? } else { ?>

    <div class="tweet_stats">
        <div class="row">

            <div class="col-lg-2">

                <p class="_counter"><a title="Źródło" target="_blank"
                                       href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>/statuses/<?= $object->getData('twitt_id') ?>"><span
                            class="glyphicon glyphicon-new-window"></span> &nbsp;</a></p>

            </div>
        </div>
    </div>

<? } ?>