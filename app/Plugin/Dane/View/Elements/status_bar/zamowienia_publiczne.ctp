<ul class="dataHighlights col-xs-12">
    <li class="dataHighlight col-xs-3">
        <? if ($object->getData('status_id') == '0') {
            ?>
            <span class="_label label label-success">Zamówienie otwarte</span>
        <? } elseif ($object->getData('status_id') == '2') { ?>
            <span class="_label label label-danger">Zamówienie rozstrzygnięte</span>
        <? } ?>

        <? if ($object->getData('wartosc_cena')) { ?>
            <span class="_value">na kwotę <?= number_format_h($object->getData('wartosc_cena')); ?> PLN</span>
        <? } ?>
    </li>

    <li class="dataHighlight col-xs-3">
        <p class="_label">Zamawiający</p>

        <p class="_value"><a
                href="/dane/zamowienia_publiczne_zamawiajacy/<?= $object->getData('zamawiajacy_id'); ?>"><?= $object->getData('zamawiajacy_nazwa'); ?></a>
        </p>
    </li>

    <li class="dataHighlight col-xs-3">
        <p class="_label">Tryb</p>

        <p class="_value"><?= $object->getData('zamowienia_publiczne_tryby.nazwa') ?></p>
    </li>

    <? if ($object_aggs['all']['dokumenty']['wykonawcy']['top']['buckets']) { ?>
        <li class="dataHighlight col-xs-3">
            <p class="_label">Wykonawcy</p>

            <? foreach ($object_aggs['all']['dokumenty']['wykonawcy']['top']['buckets'] as $b) { ?>
                <p class="_value"><a href="#"><?= $b['nazwa']['buckets'][0]['key'] ?></a>
                    - <?= number_format_h($b['cena']['value']) ?> <?= $b['waluta']['buckets'][0]['key'] ?></p>
            <? } ?>
        </li>
    <? } ?>
</ul>