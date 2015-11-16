<ul class="dataHighlights oneline col-xs-12">
    <? $zamawiajacy_id = $object->getData('zamawiajacy_id');
    if (isset($zamawiajacy_id) && !empty($zamawiajacy_id)) { ?>
        <li class="dataHighlight col-sm-6">
            <p class="_label">Zamawiający</p>

            <p class="_value"><a
                    href="/dane/zamowienia_publiczne_zamawiajacy/<?= $object->getData('zamawiajacy_id'); ?>"><?= $object->getData('zamawiajacy_nazwa'); ?></a>
            </p>
        </li>
    <? } ?>

    <? $zamowienia_publiczne_tryby_nazwa = $object->getData('zamowienia_publiczne_tryby.nazwa');
    if (isset($zamowienia_publiczne_tryby_nazwa) && !empty($zamowienia_publiczne_tryby_nazwa)) { ?>
        <li class="dataHighlight col-sm-6">
            <p class="_label">Tryb</p>

            <p class="_value"><?= $zamowienia_publiczne_tryby_nazwa; ?></p>
        </li>
    <? } ?>
</ul>
