<?

$forceLabel = false;

?>

<div class="content<? if ($object->getPosition()) { ?> col-md-11<? } ?>">

    <? if ($object->force_hl_fields || $forceLabel) { ?>
        <p class="header">
            <?= $object->getLabel(); ?>
        </p>
    <? } ?>

    <p class="title">
        <a href="<?= $object->getUrl() ?>"
           title="<?= strip_tags($object->getData('zamowienia_publiczne_dokumenty.nazwa')) ?>">
            <?= $this->Text->truncate($object->getData('zamowienia_publiczne_dokumenty.nazwa'), 200) ?>
        </a>
    </p>



    <?

    $cena = false;
    $waluta = false;
    if ($wykonawcy = $object->getStatic('wykonawcy')) {
        foreach ($wykonawcy as $w) {
            if ($w['krs_id'] == $this->request->params['id'])
                $cena = $w['cena'];
            $waluta = $w['waluta'];
        }
    }

    if ($cena) {
        ?>

        <div class="row dataHighlights dimmed inl">
            <div class="dataHighlight col-md-12">
                <p class="_label">Cena:</p>

                <p class="_value"><span class="base"><?= number_format_h($cena) ?> <?= $waluta ?></span></p>
            </div>
        </div>

    <? } ?>

    <p class="col-lg-12 pull-top-right">
        <a href="<?= $object->getUrl() ?>">Szczegóły &raquo;</a>
    </p>
</div>
