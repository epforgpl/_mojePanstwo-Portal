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
                    <div class="observeButton btn btn-icon btn-primary">
                        <i class="icon" data-icon-applications="&#xe60a;"></i>Obserwuj...
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>