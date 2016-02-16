<div class="suggesterBlockModal directBlock">
    <form class="suggesterBlock" action="<? if (isset($action)) {
        echo $action;
    } else {
        echo '/dane/szukaj';
    }
    if (isset($app)) { ?>?app=<?= $app ?><? } ?>">
        <div class="main_input input-group">
            <label for="autocompleteDatasearch" class="wcag-hidden"><?= $placeholder ?></label>
            <input id="autocompleteDatasearch" name="q" value="" type="text" autocomplete="off"
                   class="datasearch form-control"
                   placeholder="<?= $placeholder ?>" <?php if (isset($app)) echo 'data-app="' . $app . '"'; ?>
                   data-autocompletion="true"/>
                        <span class="input-group-btn">
                            <button class="btn btn-success input-md" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
        </div>
    </form>
</div>

