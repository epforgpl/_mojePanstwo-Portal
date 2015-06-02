<ul class="dataHighlights col-xs-12">
    <? $zamawiajacy_id = $object->getData('zamawiajacy_id');
    if (isset($zamawiajacy_id) && !empty($zamawiajacy_id)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Zamawiający</p>

            <p class="_value"><a
                    href="/dane/zamowienia_publiczne_zamawiajacy/<?= $object->getData('zamawiajacy_id'); ?>"><?= $zamawiajacy_id; ?></a>
            </p>
        </li>
    <? } ?>

    <? $zamowienia_publiczne_tryby_nazwa = $object->getData('zamowienia_publiczne_tryby.nazwa');
    if (isset($zamowienia_publiczne_tryby_nazwa) && !empty($zamowienia_publiczne_tryby_nazwa)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Tryb</p>

            <p class="_value"><?= $zamowienia_publiczne_tryby_nazwa; ?></p>
        </li>
    <? } ?>

    <?
    $bucket = $object_aggs['all']['dokumenty']['wykonawcy']['top']['buckets'];
    if (isset($bucket) && !empty($bucket)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Wykonawcy</p>

            <? foreach ($bucket as $b) { ?>
                <p class="_value"><a href="#"><?= $b['nazwa']['buckets'][0]['key'] ?></a>
                    - <?= number_format_h($b['cena']['value']) ?> <?= $b['waluta']['buckets'][0]['key'] ?></p>
            <? } ?>
        </li>
    <? } ?>
</ul>