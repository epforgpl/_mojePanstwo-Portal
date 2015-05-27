<ul class="dataHighlights col-xs-12">
    <li class="dataHighlight col-xs-3">
        <p class="_label">Wysłano</p>

        <p class="_value"><?= dataSlownie($object->getData('czas_utworzenia')) ?></p>
    </li>

    <li class="dataHighlight col-xs-3">
        <p id="sources">
            <a target="_blank"
               href="https://twitter.com/<?= $object->getData('twitter_accounts.twitter_name') ?>/status/<?= $object->getData('twitter.src_id') ?>">Źródło</a>
        </p>
    </li>
</ul>