<?

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');

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
    class="appHeader dataobject-head objectRender <?= $object->getDataset() ?> dataobject"<? if (isset($object_editable) && !empty($object_editable)) { ?> data-editables='<?= json_encode($object_editable) ?>'<? } ?>
    data-url="<?= urlencode($object->getUrl()) ?>" data-dataset="<?= $object->getDataset() ?>"
    data-object_id="<?= $object->getId() ?>" data-global-id="<?= $object->getGlobalId() ?>">
    <div class="container">
        <div class="holder">
            <div class="row">
                <div class="col-md-10">

                    <? /*
                    <ul class="breadcrumb">
                        <?php foreach ($_breadcrumbs as $bread) { ?>
                            <li><? if (isset($bread['href'])) { ?><a href="<?= $bread['href'] ?>"
                                                                     target="_self"><? } ?><?= $bread['label'] ?><? if (isset($bread['href'])) { ?></a><? } ?>
                            </li>
                        <? } ?>
                    </ul>
                    */ ?>

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

                    <? if (isset($_observeOptions) && !empty($_observeOptions)) {
                        $subscription = @$object->getLayer('subscription'); ?>
                        <div class="option">
                            <div class="btn optionBtn btn-observe <? echo (isset($subscription) && !empty($subscription)) ? 'btn-success' : 'off btn-primary'; ?>">
                                <span class="icon"
                                      data-icon-applications="&#xe60a;"></span> <?= (isset($subscription) && !empty($subscription)) ? 'Obserwujesz' : 'Obserwuj' ?>
                            </div>
                        </div>
                    <? } ?>

                    <? if (isset($_collectionsOptions) && !empty($_collectionsOptions)) { ?>
                        <div class="option">
                            <div data-toggle="modal" data-target="#collectionsModal"
                                 class="btn optionBtn btn-primary off">
                                <span class="icon" data-icon-applications="&#xe618;"></span> Dodaj do kolekcji
                            </div>
                        </div>
                    <? } ?>

                    <? if (isset($_manageOptions) && !empty($_manageOptions)) { ?>
                        <div class="option">
                            <div data-toggle="modal" data-target="#manageModal" class="btn optionBtn btn-danger off">
                                <i class="glyphicon glyphicon-cog" aria-hidden="true"></i> Zarządzaj
                            </div>
                        </div>
                    <? } ?>

                </div>
            </div>
            <? if( $desc = $object->getPageDescription() ) {?>
            <div class="row">
                <div class="col-xs-10">
                    <div class="object-description">
	                    <?= $desc; ?>
                    </div>
                </div>
            </div>
            <? } ?>
        </div>
    </div>
</div>

<? echo $this->Element('menu'); ?>
