<ul class="dataHighlights col-xs-12">
    
    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Zamawiający</p>

        <p class="_value"><a
                href="/dane/zamowienia_publiczne_zamawiajacy/<?= $object->getData('zamawiajacy_id'); ?>"><?= $object->getData('zamawiajacy_nazwa'); ?></a>
        </p>
    </li>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <p class="_label">Tryb</p>

        <p class="_value"><?= $object->getData('zamowienia_publiczne_tryby.nazwa') ?></p>
    </li>

    <? if ($object_aggs['all']['dokumenty']['wykonawcy']['top']['buckets']) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Wykonawcy</p>

            <? foreach ($object_aggs['all']['dokumenty']['wykonawcy']['top']['buckets'] as $b) { ?>
                <p class="_value"><a href="#"><?= $b['nazwa']['buckets'][0]['key'] ?></a>
                    - <?= number_format_h($b['cena']['value']) ?> <?= $b['waluta']['buckets'][0]['key'] ?></p>
            <? } ?>
        </li>
    <? } ?>
</ul>