<? $this->Combinator->add_libs('js', 'Pisma.suggester.js'); ?>

<div class="searcher form-group has-feedback">
    <div class="col-md-12">
        <div class="input-group">
            <input class="form-control hasclear input-lg<? if (isset($url) && !empty($q)) {
                echo ' clearer-on';
            } ?>"
                   placeholder="<?= isset($placeholder) ? $placeholder : 'Szukaj...'; ?>"
                   type="text"
                   name="q"
                   value="<?= $q ?>"
                   data-dataset="<?= isset($dataset) ? $dataset : '*'; ?>"
                   data-url="<?= @$url ?>"
                   data-autocompletion="true"
                   autocomplete="off"
                   required
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