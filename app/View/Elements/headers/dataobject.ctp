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
            <div class="col-md-11">
                <? if (isset($treeList)) { ?>
                    <ul class="breadcrumb tree">
                        <li>
                            <h1 class="title">
                                <?php foreach ($_breadcrumbs as $bread) { ?>
                                    <a href="<?= $bread['href'] ?>" target="_self"><?= $bread['label'] ?></a>
                                <? } ?>
                            </h1>
                            <ul>
                                <li class="e">
                                    <?= $object->getData('bdl_wskazniki.kategoria_tytul'); ?>
                                    <ul>
                                        <li class="e">
                                            <?= $object->getData('bdl_wskazniki.grupa_tytul'); ?>
                                            <ul>
                                                <li class="e"><?= $object->getData('bdl_wskazniki.tytul'); ?></li>
                                            </ul>
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
                    <h2>
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
                    </h2>
                </div>
                <div class="status">
                    <?= @$this->element('status_bar/' . $object->getDataset(), array('plugin' => 'Dane')) ?>
                </div>
            </div>
            <?php if (isset($_observeOptions) && !empty($_observeOptions)) { ?>
                <div class="col-md-1">
                    <div class="observeButton pull-right btn btn-icon btn-warning">
                        <i class="icon" data-icon-applications="&#xe60a;"></i>Obserwuj...
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>