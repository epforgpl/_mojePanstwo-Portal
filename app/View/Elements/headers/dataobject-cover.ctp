<?
echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));

/** @var Object $object */
$object = $this->viewVars['object'];
$dataset = @$object->getDataset();
$object_id = @$object->getId();
$pageLayer = @$object->getLayer('page');
$objectOptions = $this->viewVars['objectOptions'];

/** @var Object $microdata */
$objectOptions['microdata'] = $microdata;

if (!isset($renderFile) || !$renderFile)
    $renderFile = 'page';
?>

<div class="appHeader dataobject dataobject-cover<? if ($pageLayer['logo']) echo ' cover-logo';
if ($pageLayer['cover']) echo ' cover-background'; ?>" data-dataset="<?= $object->getDataset() ?>"
     data-object_id="<?= $object->getId() ?>"<? if (isset($object_editable) && !empty($object_editable)) { ?> data-editables='<?= json_encode($object_editable) ?>'<? } ?>>

    <div class="headlineBar" <? if ($pageLayer['cover']) {
        echo ' style="background-image: url(http://sds.tiktalik.com/portal/pages/cover/' . $dataset . '/' . $object_id . '.jpg)"';
    } ?>>
        <? if (isset($pageLayer['credits']) && !empty($pageLayer['credits'])) { ?>
            <div class="credits">
            <small>Prawa autorskie:</small><?= $pageLayer['credits'] ?></div><? } ?>
        <div class="container">
            <? if ($pageLayer['logo']) { ?>
                <div class="logoBox">
                    <img src="http://sds.tiktalik.com/portal/pages/logo/<?= $dataset ?>/<?= $object_id ?>.png"/>
                </div>
            <? } ?>
            <div class="holder row">
                <div class="holderBlock col-md-9">
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
                        <h1>
                            <?php if ($object->getUrl() != false){ ?>
                            <a class="trimTitle" href="<?= $object->getUrl() ?>"
                               title="<?= strip_tags($object->getTitle()) ?>">
                                <?php } ?>
                                <span<? if ($microdata['titleprop']) { ?> itemprop="<?= $microdata['titleprop'] ?>"<? } ?>><?= trim($object->getTitle()) ?><? if (isset($pageLayer['moderated']) && $pageLayer['moderated']) { ?>
                                        <i class="glyphicon glyphicon-ok-sign"></i><? } ?></span>
                                <?php if ($object->getUrl() != false){ ?>
                            </a>
                        <? if ($object->getTitleAddon()) {
                            echo '<small>' . $object->getTitleAddon() . '</small>';
                        } ?>
                        <?php } ?>
                        </h1>
                    </div>
                </div>
                <div class="col-md-3 options">
                    <? if (isset($_observeOptions) && !empty($_observeOptions)) { ?>
                        <div class="opt"><?= $this->element('modals/dataobject-observe'); ?></div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="statusBar">
        <div class="container">
            <div class="holder row">
                <div class="col-xs-10">
                    <div class="status">
                        <?= @$this->element('status_bar/' . $object->getDataset(), array('plugin' => 'Dane')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>