<? $this->Combinator->add_libs('js', 'suggester.js'); ?>

<form action="" method="get" class="form-horizontal suggesterBlock row col-xs-12">
    <? $datasets = explode(",", $dataset);
    foreach ($datasets as $d) {
        echo '<input type="hidden" name="dataset[]" value="' . $d . '" />';
    }
    ?>
    <div class="searcher form-group has-feedback">
        <div class="col-md-12">
            <div class="input-group">
                <input class="form-control hasclear input-lg"
                       placeholder="<?= isset($placeholder) ? $placeholder : 'Szukaj...'; ?>"
                       type="text"
                       name="q"
                       value="<?= $q ?>"
                       required
                       data-dataset="<?= isset($dataset) ? $dataset : '*'; ?>"
                       data-url="<?= $url ?>"
                    />
                <? if (isset($url) && !empty($q)) { ?>
                    <a class="clearer" href="<?= $url ?>">
                        <span class="form-control-feedback" aria-hidden="true">&times;</span>
                    </a>
                <? } ?>
                <div class="input-group-btn">
                    <button class="btn btn-primary input-lg" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>