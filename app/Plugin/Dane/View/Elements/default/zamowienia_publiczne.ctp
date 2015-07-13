<?
$liczba_wykonawcow = count($object->getData('wykonawca_id'));
?>

<div class="row dataHighlights dimmed">

    <? if ($object->getData('wykonawca_str')) { ?>

        <div class="dataHighlight col-md-6"><? if ($object->getData('wykonawca_str')) { ?><p class="_label">
                Wykonawc<? if ($liczba_wykonawcow > 1) { ?>y<? } else { ?>a<? } ?>
                :<? if ($liczba_wykonawcow > 1) { ?> <span
                    class="label label-default"><?= $liczba_wykonawcow ?></span><? } ?></p><p
                    class="_value"><?= $this->Text->truncate($object->getData('wykonawca_str'), 50) ?></p><? } ?>
        </div>
        <div class="dataHighlight col-md-6"><? if ($object->getData('wartosc_cena')) { ?><p class="_label">Cena:</p>
                <p
                    class="_value"><?= _currency($object->getData('wartosc_cena')) ?></p><? } ?></div>

    <? } else { ?>

        <div class="dataHighlight col-md-12"><? if ($object->getData('wartosc_cena')) { ?><p class="_label">
                Cena:</p><p
                class="_value"><?= _currency($object->getData('wartosc_cena')) ?></p><? } ?></div>

    <? } ?>

</div>

<?= $this->Dataobject->highlights($hlFields, $hlFieldsPush, $defaults) ?>

</div>
</div>

<div>
    <div>