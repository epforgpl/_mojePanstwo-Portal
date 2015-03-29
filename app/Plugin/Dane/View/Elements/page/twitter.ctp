<?
$source = $object->getLayer('source');
?>
<p class="account"><a href="#"><?= $object->getData('twitter_accounts.name') ?></a>
    <span>via <?= @$source['name'] ?></span></p>

<h1 class="_">
    <?php echo $object->getData('html') ?>
</h1>

<? if ($object->getData('twitter_account_id')) { ?>
    <div class="tweet_stats" style="border-top: 1px solid #CCC; margin: 10px 0 0; text-align: left;">
        <div class="row">
            <div class="col-lg-2">


                <p class="_counter"><a title="Liczba retweetów" href="/dane/twitter/<?= $object->getId() ?>"><span
                            class="glyphicon glyphicon-retweet"></span> <?= number_format($object->getData('liczba_retweetow'), 0, '.', ' ') ?>
                    </a></p>


            </div>
            <div class="col-lg-2">

                <p class="_counter"><a title="Licza odpowiedzi" href="/dane/twitter/<?= $object->getId() ?>"><span
                            class="glyphicon glyphicon-transfer"></span> <?= $object->getData('liczba_odpowiedzi') ?>
                    </a></p>

                <? /*<p class="_label"><?= __d('media', 'LC_PANSTWOINTERNET_ODPOWIEDZI') ?></p> */ ?>

            </div>
            <div class="col-lg-2">

                <p class="_counter"><a target="_blank"
                                       href="https://twitter.com/<?= $object->getData('twitter_user_screenname') ?>/statuses/<?= $object->getData('twitt_id') ?>"><span
                            class="glyphicon glyphicon-new-window"></span> Źródło</a></p>

            </div>
        </div>
    </div>
<? } ?>


</div>
</div>

<div>
    <div>


