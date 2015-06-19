<?

$objectRenderOptions = array(
    'forceLabel' => (isset($dataBrowserObjectRender) && isset($dataBrowserObjectRender['forceLabel'])) ? (boolean)$dataBrowserObjectRender['forceLabel'] : false,
);


$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);

// debug( $object->getStatic() );

$shortTitle = $object->getData('zamowienia_publiczne_dokumenty.nazwa');

$object_content_sizes = array(2, 10);

// debug( $object->getData() ); 

$this->Dataobject->setObject($object);
?>
<div class="objectRender<? if ($alertsStatus) {
    echo " unreaded";
} else {
    echo " readed";
} ?><? if ($classes = $object->getClasses()) {
    echo " " . implode(' ', $classes);
} ?>"
     oid="<?php echo $object->getId() ?>" gid="<?php echo $object->getGlobalId() ?>">

    <div class="row">

        <div class="data col-xs-12">

            <? if ($sentence = $object->getSentence()) { ?>
                <p class="sentence"><?= $sentence ?></p>
            <? } ?>

            <div>

                <div class="content">

                    <? if ($alertsButtons) { ?>
                        <div class="alertsButtons pull-right">
                            <input class="btn btn-xs read" type="button"
                                   value="<?php echo __d('powiadomienia', 'LC_POWIADOMIENIA_OPTIONS_ALERT_BUTTON_READ'); ?>"/>
                            <input class="btn btn-xs unread" type="button"
                                   value="<?php echo __d('powiadomienia', 'LC_POWIADOMIENIA_OPTIONS_ALERT_BUTTON_UNREAD'); ?>"/>
                        </div>
                    <? } ?>

                    <p class="header">
                        Zamówienie publiczne z dnia <?= dataSlownie($object->getDate()) ?>
                    </p>

                    <p class="title">
                        <?php if ($object->getUrl() != false){ ?>
                        <a href="<?= $object->getUrl() ?>" title="<?= strip_tags($object->getTitle()) ?>">
                            <?php } ?>
                            <?= $this->Text->truncate($shortTitle, 150) ?>
                            <?php if ($object->getUrl() != false){ ?>
                        </a> <?
                    }
                    if ($object->getTitleAddon()) {
                        echo '<small>' . $object->getTitleAddon() . '</small>';
                    } ?>
                    </p>

                    <? if ($metaDesc = $object->getMetaDescription()) { ?>
                        <p class="meta meta-desc"><?= $metaDesc ?></p>
                    <? } ?>

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

                        <div class="row dataHighlights dimmed inl" style="display: block !important;">
                            <div class="dataHighlight col-md-12">
                                <p class="_label">Cena:</p>

                                <p class="_value"><span class="base"><?= number_format_h($cena) ?> <?= $waluta ?></span>
                                </p>
                            </div>
                        </div>

                    <? } ?>

                </div>

            </div>
        </div>
    </div>
</div>