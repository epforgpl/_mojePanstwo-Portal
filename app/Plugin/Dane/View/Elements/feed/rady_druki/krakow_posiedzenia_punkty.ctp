<?

$hlFields = array();
$forceLabel = false;

$thumbSize = 2;
$size = 2;

$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.Krakow_glosowania_votings.js');
$this->Combinator->add_libs('css', $this->Less->css('krakow_glosowania_votings', array('plugin' => 'Dane')));

if ($object->getThumbnailUrl($thumbSize)) {
    ?>

    <div class="attachment col-xs-<?= $size + 1 ?> col-md-<?= $size ?> text-center">
        <?php if ($object->getUrl() != false) { ?>
    <?php if ($object->getData('dokument_id')) { ?>
        <span class="glyphicon glyphicon-search documentFastCheck" aria-hidden="true"
              data-documentid="<?= $object->getData('dokument_id'); ?>" data-toogle="modal"
              data-target="#documentFastCheckModal"></span>
    <?php } ?>
        <a class="thumb_cont" href="<?= $object->getUrl() ?>/tresc">
            <?php } ?>
            <img class="thumb pull-right" src="<?= $object->getThumbnailUrl($thumbSize) ?>"
                 alt="<?= strip_tags($object->getTitle()) ?>" onerror="imgFixer(this)"/>
            <?php if ($object->getUrl() != false) { ?>
        </a>
    <?php } ?>

    </div>
    <div class="content col-xs-<?= 12 - $size - 1 ?> col-md-<?= 12 - $size ?>">


        <? if ($object->force_hl_fields || $forceLabel) { ?>
            <p class="header">
                <?= $object->getLabel(); ?>
            </p>
        <? } ?>

        <p class="title">
            <?php if ($object->getUrl() != false) { ?>
            <a href="<?= $object->getUrl() ?>/tresc" title="<?= strip_tags($object->getTitle()) ?>">
                <?php } ?>
                <?= $this->Text->truncate($object->getShortTitle(), 200) ?>
                <?php if ($object->getUrl() != false) { ?>
            </a> <?
        }
        if ($object->getTitleAddon()) {
            echo '<small>' . $object->getTitleAddon() . '</small>';
        } ?>
        </p>

        <?= $this->Dataobject->highlights($hlFields, $hlFieldsPush, $defaults) ?>


    </div>

<? } else { ?>
    <div class="content">

        <? if ($object->force_hl_fields || $forceLabel) { ?>
            <p class="header">
                <?= $object->getLabel(); ?>
            </p>
        <? } ?>

        <? if (
            ($static = $object->getStatic()) &&
            isset($static['glosowanie']) &&
            ($glosowanie = $static['glosowanie'])
        ) { ?>
            <div class="krakow_glosowania_voting_chart" data-za="<?= (int)$glosowanie['liczba_glosow_za'] ?>"
                 data-przeciw="<?= (int)$glosowanie['liczba_glosow_przeciw'] ?>"
                 data-nieobecni="<?= (int)$glosowanie['liczba_nieobecni'] ?>"
                 data-wstrzymanie="<?= (int)$glosowanie['liczba_glosow_wstrzymanie'] ?>"></div>
        <? } ?>

        <p class="title">
            <a class="btn btn-primary btn-xs" href="<?= $object->getUrl() ?>">Zobacz szczegóły</a>
        </p>

        <?= $this->Dataobject->highlights($hlFields, $hlFieldsPush, $defaults) ?>


    </div>
<? } ?>