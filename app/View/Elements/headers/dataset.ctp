<div class="appHeader dataset">
    <div class="container">
        <div class="holder row">
            <div class="col-md-8">
                <ul class="breadcrumb">
                    <?php foreach ($_breadcrumbs as $bread) { ?>
                        <li><a href="<?= $bread['href'] ?>" target="_self"><?= $bread['label'] ?></a></li>
                    <? } ?>
                </ul>
                <div class="title"><h1><?= $object->getTitle(); ?></h1></div>
            </div>
            <?php if (isset($_observeOptions)) { ?>
                <div class="col-md-4">
                    <button class="observeButton pull-right btn btn-warning">Obserwuj...</button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>