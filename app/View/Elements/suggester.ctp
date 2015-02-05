<div class="globalSearch">
    <div
        class="floatingPart col-xs-10 col-sm-9 col-md-8 col-lg-7 col-xs-offset-1 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">
        <form class="suggesterBlock" action="/dane/szukaj<? if (isset($app)) { ?>?app=<?= $app ?><? } ?>">
            <div class="input-group main_input">
                <input name="q" value="" type="text" autocomplete="off" class="datasearch form-control input-lg"
                       placeholder="<?= $placeholder ?>"
                    <?php if (isset($app)) {
                        echo 'data-app="' . $app . '"';
                    } ?>
                    />
        <span class="input-group-btn">
              <button class="btn btn-default btn-lg" type="submit" data-icon="&#xe600;"></button>
        </span>
            </div>
        </form>
    </div>
</div>