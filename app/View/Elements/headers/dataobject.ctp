<?
/** @var Object $object */
$object = $this->viewVars['object'];
$objectOptions = $this->viewVars['objectOptions'];
/** @var Object $microdata */
$objectOptions['microdata'] = $microdata;

if (!isset($renderFile) || !$renderFile)
    $renderFile = 'page';
?>

<div class="appHeader dataobject" data-dataset="<?= $object->getDataset() ?>" data-object_id="<?= $object->getId() ?>">
    <div class="container">
        <div class="holder row">
            <div class="col-md-10">
                
                <ul class="breadcrumb">
                    <?php foreach ($_breadcrumbs as $bread) { ?>
                        <li><? if( isset($bread['href']) ) { ?><a href="<?= $bread['href'] ?>" target="_self"><? } ?><?= $bread['label'] ?><? if( isset($bread['href']) ) { ?></a><? } ?></li>
                    <? } ?>
                </ul>

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