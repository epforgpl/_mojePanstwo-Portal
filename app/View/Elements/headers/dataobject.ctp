<?

echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));

/** @var Object $object */
$object = $this->viewVars['object'];
$objectOptions = $this->viewVars['objectOptions'];
/** @var Object $microdata */
$objectOptions['microdata'] = $microdata;

if (!isset($renderFile) || !$renderFile)
    $renderFile = 'page';

?>

<div
    class="appHeader dataobject"<? if (isset($object_editable) && !empty($object_editable)) { ?> data-editables='<?= json_encode($object_editable) ?>'<? } ?>
    data-url="<?= urlencode($object->getUrl()) ?>" data-dataset="<?= $object->getDataset() ?>"
    data-object_id="<?= $object->getId() ?>" data-global-id="<?= $object->getGlobalId() ?>">
    <div class="container">
        <div class="holder">
            <div class="row">
                <div class="col-md-10">
                    <ul class="breadcrumb">
                        <?php foreach ($_breadcrumbs as $bread) { ?>
                            <li><? if (isset($bread['href'])) { ?><a href="<?= $bread['href'] ?>"
                                                                     target="_self"><? } ?><?= $bread['label'] ?><? if (isset($bread['href'])) { ?></a><? } ?>
                            </li>
                        <? } ?>
                    </ul>

					<? if( !isset($objectOptions['renderTitle']) || $objectOptions['renderTitle'] ) { ?>
	                    <div class="title<? if (isset($treeList)) echo ' hide'; ?>">
	                        <h1 class="smaller">
	                            <?php if ($object->getUrl() != false){ ?>
	                            <a class="trimTitle" href="<?= $object->getUrl() ?>"
	                               title="<?= htmlspecialchars(strip_tags($object->getTitle())) ?>">
	                                <?php } ?>
	                                <?= $object->geticon() ?>
	                                <div
	                                    class="titleName"<? if ($microdata['titleprop']) { ?> itemprop="<?= $microdata['titleprop'] ?>"<? } ?>><?= $object->getTitle() ?></div>

	                                <?php if ($object->getUrl() != false){ ?>
	                            </a>
	                        <? if ($object->getTitleAddon()) {
	                            echo '<small>' . $object->getTitleAddon() . '</small>';
	                        } ?>
	                        <?php } ?>
	                        </h1>
	                    </div>
                    <? } ?>

                </div>
                <div class="col-md-2 DataObjectOptions">

                    <? if (isset($_observeOptions) && !empty($_observeOptions)) { ?>
                        <div class="option"><?= $this->element('modals/dataobject-observe'); ?></div>
                    <? } ?>

                    <? if (isset($_collectionsOptions) && !empty($_collectionsOptions)) { ?>
                        <div class="option"><?= $this->element('modals/dataobject-collections'); ?></div>
                    <? } ?>

                    <? if (isset($_manageOptions) && !empty($_manageOptions)) { ?>
                        <div class="option"><?= $this->element('modals/dataobject-manage'); ?></div>
                    <? } ?>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-10">
                    <div class="status">
                        <?= @$this->element('status_bar/' . $object->getDataset(), array('plugin' => 'Dane')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<? echo $this->Element('menu'); ?>
