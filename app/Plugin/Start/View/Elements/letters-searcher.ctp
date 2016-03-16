<? $this->Combinator->add_libs('js', 'Start.suggester.js'); ?>

<div class="searcher form-group has-feedback">
    <div class="col-md-12">
            <input class="form-control hasclear input-md<? if (isset($url) && !empty($q)) {
                echo ' clearer-on';
            } ?>"
                   placeholder="<?= isset($placeholder) ? $placeholder : 'Szukaj...'; ?>"
                   type="text"
                   name="q"
                   value="<?= htmlentities(stripcslashes($q), ENT_QUOTES | ENT_IGNORE, "UTF-8") ?>"
                   data-dataset="<?= isset($dataset) ? $dataset : '*'; ?>"
                   data-url="<?= @$url ?>"
                   data-autocompletion="true"
                   autocomplete="off"
                   <?= isset($notRequired) ? '' : 'required'; ?>
                />
            <? if (isset($url) && !empty($q)) { ?>
                <a class="clearer" href="<?= $url ?>">
                    <span class="form-control-feedback" aria-hidden="true">&times;</span>
                </a>
            <? } ?>
        </div>
</div>
