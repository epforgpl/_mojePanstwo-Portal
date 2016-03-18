<?

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');

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
     data-object_id="<?= $object->getId() ?>"<? if (isset($object_editable) && !empty($object_editable)) { ?> data-editables='<?= json_encode($object_editable) ?>'<? } ?>
     data-global-id="<?= $object->getGlobalId() ?>">

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
                        <img src="<?= $src ?>"/>
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
                <div class="holderBlock col-xs-9">

                    <? /* if( $_breadcrumbs ) { ?>
                        <ul class="breadcrumb">
                            <?php foreach ($_breadcrumbs as $bread) { ?>
                                <li><a href="<?= $bread['href'] ?>" target="_self"><?= $bread['label'] ?></a></li>
                            <? } ?>
                        </ul>
                    <? } */ ?>

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
                <div class="DataObjectOptions col-xs-3">

                    <? if (isset($_observeOptions) && !empty($_observeOptions)) {
                        $subscription = @$object->getLayer('subscription'); ?>
                        <div class="option">
                            <div data-toggle="modal" data-target="#observeModal"
                                 class="btn optionBtn <? echo (isset($subscription) && !empty($subscription)) ? 'btn-success' : 'off btn-primary'; ?>">
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
