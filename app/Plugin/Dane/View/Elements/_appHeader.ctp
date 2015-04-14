<?php $this->Combinator->add_libs('css', $this->Less->css('searchbar')) ?>

<div class="searchBar _fullwidth">
    <div class="container">
        <div class="col-md-12">

            <? if (false && !(isset($q) && $q)) { ?>
                <div class="info">
                    <?= __d('dane', 'LC_DANE_CATALOG_HEADER'); ?>
                </div>
            <? } ?>

            <form action="/dane" method="get">
                <div class="col-md-12" id="searchFor">
                    <div class="input-group">
                        <input type="text" name="q"
                               placeholder="<?php echo __d('dane', "LC_SEARCH_BAR_PLACEHOLDER") ?>"
                               class="form-control input-lg"
                               value="<?= htmlspecialchars($q) ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit" data-icon="&#xe600;"></button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>