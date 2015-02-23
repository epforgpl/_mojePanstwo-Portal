<div class="suggesterBlockModal modal fade" id="suggesterBlock" tabindex="-1" role="dialog"
     aria-labelledby="suggesterBlockModal"
     aria-hidden="true">
    <div class="modal-dialog container">
        <div class="modal-content col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
            <div class="modal-body">
                <form class="suggesterBlock" action="<? if (isset($action)) {
                    echo $action;
                } else {
                    echo '/dane/szukaj';
                };
                if (isset($app)) { ?>?app=<?= $app ?><? } ?>">
                    <div class="input-group main_input">
                        <input name="q" value="" type="text" autocomplete="off" class="datasearch form-control input-lg"
                               placeholder="<?= $placeholder ?>" <?php if (isset($app)) {
                            echo 'data-app="' . $app . '"';
                        } ?>/>
                        <span class="input-group-btn">
                              <button class="btn btn-default btn-lg" type="submit" data-icon="&#xe600;"></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>