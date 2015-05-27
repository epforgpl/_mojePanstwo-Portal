<div class="appHeader app">
    <div class="container">
        <div class="holder row">
            <div class="col-md-8">
                <? if (isset($_app['name'])) { ?>
                    <h1>
                        <a href="<?= $_app['href'] ?>"><i class="glyphicon"
                                                          data-icon-applications="<?= $_app['icon'] ?>"></i><?= $_app['name'] ?>
                        </a>
                    </h1>
                <? } ?>
            </div>

            <? if (isset($dataBrowser['chapters']) && !empty($dataBrowser['chapters'])) { ?>
                <div class="col-md-4">
                    <div class="goto text-right">
                        <select class="selectpicker" data-style="btn-default" title="Przejdź do...">
                            <? foreach ($dataBrowser['chapters']['chapters'] as $chapter_id => $chapter) { ?>
                                <option
                                    <? if ((isset($dataBrowser['chapters']['selected'])) && ($chapter_id == $dataBrowser['chapters']['selected'])) { ?>selected="selected"
                                    <? } ?>href="<?= $chapter['href'] ?>"><?= $chapter['label'] ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
</div>