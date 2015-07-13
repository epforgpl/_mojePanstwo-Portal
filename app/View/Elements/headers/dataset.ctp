<div class="appHeader dataset">
    <div class="container">
        <div class="holder row">
            <div class="col-md-10">
                <ul class="breadcrumb">
                    <?php foreach ($_breadcrumbs as $bread) { ?>
                        <li><a href="<?= $bread['href'] ?>" target="_self"><?= $bread['label'] ?></a></li>
                    <? } ?>
                </ul>
                <div class="title"><h1><?= $object->getTitle(); ?></h1></div>
            </div>
            <?php if (isset($_observeOptions) && !empty($_observeOptions)) { ?>
                <div class="col-md-2">
                    <? echo $this->element('modals/dataobject-observe'); ?>
                </div>
            <? } ?>
        </div>
    </div>
</div>