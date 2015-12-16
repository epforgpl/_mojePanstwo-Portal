<div class="suggesterBlockModal modal fade" id="suggesterBlock" tabindex="-1" role="dialog"
     aria-labelledby="suggesterBlockModal"
     aria-hidden="true">
    <div class="modal-dialog container">
        <div class="modal-content col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <div class="modal-body">
                <form class="suggesterBlock" action="<? if (isset($action)) {
                    echo $action;
                } else {
                    echo '/dane/szukaj';
                };
                if (isset($app)) { ?>?app=<?= $app ?><? } ?>">
                    <div class="main_input">
                        <span class="glyph-addon" data-icon="&#xe600;"></span>
                        <input name="q" value="" type="text" autocomplete="off" class="datasearch form-control input-lg"
                               placeholder="<?= $placeholder ?>" <?php if (isset($app)) echo 'data-app="' . $app . '"'; ?>
                               data-autocompletion="true"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
