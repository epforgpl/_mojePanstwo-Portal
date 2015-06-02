<ul class="dataHighlights col-xs-12">
    <?
    $czas_utworzenia = $object->getData('czas_utworzenia');
    if (isset($czas_utworzenia) && !empty($czas_utworzenia)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Wysłano</p>

            <p class="_value"><?= dataSlownie($czas_utworzenia) ?></p>
        </li>
    <? } ?>

    <?
    $twitter_src_id = $object->getData('twitter.src_id');
    if (isset($twitter_src_id) && !empty($twitter_src_id)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p id="sources">
                <a target="_blank"
                   href="https://twitter.com/<?= $object->getData('twitter_accounts.twitter_name') ?>/status/<?= $twitter_src_id ?>">Źródło</a>
            </p>
        </li>
    <? } ?>
</ul>