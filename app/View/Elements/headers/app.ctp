<div class="appHeader app" style="background-image: url(<?= $_app['href'] ?>/img/header.jpg)">
    <div class="container">
        <div class="holder row">
            <div class="col-md-10">
                <? if (isset($_app['name'])) { ?>
                    <h1>
                        <a href="<?= $_app['href'] ?>"><i class="glyphicon"
                                                          data-icon-applications="<?= $_app['icon'] ?>"></i><?= $_app['name'] ?>
                        </a>
                    </h1>
                <? } ?>
            </div>
        </div>
    </div>
</div>