<?
/** @var Object $object */
$object = $this->viewVars['object'];
$objectOptions = $this->viewVars['objectOptions'];
/** @var Object $microdata */
$objectOptions['microdata'] = $microdata;

if (!isset($renderFile) || !$renderFile)
    $renderFile = 'page';
?>

<div class="appHeader dataobject">
    <div class="container">
        <div class="holder row">
            <div class="col-md-10">
                <? if (isset($treeList)) { ?>
                    <ul class="breadcrumb">
                        <?php foreach ($_breadcrumbs as $bread) { ?>
                            <li><a class="normalizeText" href="<?= $bread['href'] ?>"
                                   target="_self"><?= trim($bread['label']) ?></a></li>
                        <? } ?>
                    </ul>
                    <ul class="breadcrumb tree">
                        <li>
                            <a class="normalizeText"
                               href="/bdl/#kategoria_id=<?php echo $object->getData('bdl_wskazniki.kategoria_id') ?>"><?=
                                trim($object->getData('bdl_wskazniki.kategoria_tytul'));
                                ?></a>
                            <ul>
                                <li class="e">
                                    <a class="normalizeText"
                                       href="/bdl/#kategoria_id=<?php echo $object->getData('bdl_wskazniki.kategoria_id')
                                       ?>&grupa_id=<?= $object->getData('bdl_wskazniki.grupa_id'); ?>"><?=
                                        trim($object->getData('bdl_wskazniki.grupa_tytul'));
                                        ?></a>
                                    <ul>
                                        <li class="e h1">
                                            <a class="normalizeText" href="<?php echo $object->getUrl() ?>">
                                                <h1><?= trim($object->getData('bdl_wskazniki.tytul')); ?></h1>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <? } else { ?>
                    <ul class="breadcrumb">
                        <?php foreach ($_breadcrumbs as $bread) { ?>
                            <li><a href="<?= $bread['href'] ?>" target="_self"><?= $bread['label'] ?></a></li>
                        <? } ?>
                    </ul>
                <? } ?>

                <div class="title<? if (isset($treeList)) echo ' hide'; ?>">
                    <h1 class="smaller">
                        <?php if ($object->getUrl() != false){ ?>
                        <a class="trimTitle" href="<?= $object->getUrl() ?>"
                           title="<?= strip_tags($object->getTitle()) ?>">
                            <?php } ?>

                            <span<? if ($microdata['titleprop']) { ?> itemprop="<?= $microdata['titleprop'] ?>"<? } ?>><?= $object->geticon() . '&nbsp;' . $object->getTitle() ?></span>

                            <?php if ($object->getUrl() != false){ ?>
                        </a>
                    <? if ($object->getTitleAddon()) {
                        echo '<small>' . $object->getTitleAddon() . '</small>';
                    } ?>
                    <?php } ?>
                    </h1>
                </div>
            </div>
            <?php if (isset($_observeOptions) && !empty($_observeOptions)) { ?>
                <div class="col-md-2">
                    <? echo $this->element('modals/dataobject-observe'); ?>
                </div>
            <? } ?>
            <div class="col-xs-10">
                <div class="status">
                    <?= @$this->element('status_bar/' . $object->getDataset(), array('plugin' => 'Dane')) ?>
                </div>
            </div>
        </div>
    </div>
</div>