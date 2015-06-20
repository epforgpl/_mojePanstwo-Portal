<? $this->Combinator->add_libs('js', 'suggester.js'); ?>
<form action="" method="get" class="form-horizontal suggesterBlock row col-xs-12">
    <? 
	    if( isset($autocompletion) && $autocompletion['dataset'] ) {
		    $datasets = explode(",", $autocompletion['dataset']);
		    foreach ($datasets as $d) {
		        echo '<input type="hidden" name="dataset[]" value="' . $d . '" />';
		    }
	    }
    ?>
    <div class="searcher form-group has-feedback">
        <div class="col-md-12">
            <div class="input-group">
                <input class="form-control hasclear input-lg<? if (isset($url) && !empty($q)) { echo ' clearer-on'; }?>"
                       placeholder="<?= isset($placeholder) ? $placeholder : 'Szukaj...'; ?>"
                       type="text"
                       name="q"
                       value="<?= $q ?>"
                       data-dataset="<?= $autocompletion ? $autocompletion['dataset'] : '*'; ?>"
                       data-url="<?= @$url ?>"
                       data-autocompletion="<?= $autocompletion ? 'true' : 'false' ?>"
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
    <? if (($params = $this->Paginator->params()) && isset($params['count'])) {
        $took = round($dataBrowser['took'], 2);
        ?>
        <div class="dataCounter">
            <p class="pull-left"><?= pl_dopelniacz($params['count'], 'wynik', 'wyniki', 'wyników') ?><? if ($took) { ?> (<?= $took ?> s)<? } ?></p>

            <p class="pull-right">
                <a href="#" class="link-discrete link-api-call" data-toggle="modal" data-target=".modal-api-call"><span
                        class="glyphicon glyphicon-cog"></span> API</a>
            </p>
        </div>
    <? } ?>
</form>