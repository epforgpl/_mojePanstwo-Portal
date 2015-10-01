<?
echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));
if($object->getPage())
    $this->Combinator->add_libs('css', $this->Less->css('radny_details', array('plugin' => 'PrzejrzystyKrakow')));

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
     data-object_id="<?= $object->getId() ?>"<? if (isset($object_editable) && !empty($object_editable)) { ?> data-editables='<?= json_encode($object_editable) ?>'<? } ?> data-global-id="<?= $object->getGlobalId() ?>">

    <div class="headlineBar" <? if ($pageLayer['cover']) {
        echo ' style="background-image: url(http://sds.tiktalik.com/portal/pages/cover/' . $dataset . '/' . $object_id . '.jpg)"';
    } ?>>
        <div class="container">
            <?
	            if ($pageLayer['logo']) {

		           $src = is_string($pageLayer['logo']) ? $pageLayer['logo'] : 'http://sds.tiktalik.com/portal/pages/logo/' . $dataset . '/' . $object_id . '.png'

            ?>
                <div class="logoBox hidden-xs">
                    <a href="<?= $object->getUrl() ?>">
                        <img src="<?= $src ?>" />
                    </a>
                </div>
            <? } ?>
            <div class="holder row">
                <? if (isset($pageLayer['credits']) && !empty($pageLayer['credits']) && $pageLayer['credits'] !== "") { ?>
                    <div class="credits">
                        <a class="small" href="<?= $pageLayer['credits'] ?>" target="_blank">
                            <i class="glyphicon glyphicon-copyright-mark"></i>
                        </a>
                    </div>
                <? } ?>
                <div class="holderBlock col-md-9">

                    <? if( $_breadcrumbs ) { ?>
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
                <div class="col-md-3 DataObjectOptions">

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

<? echo $this->Element('menu'); ?>
