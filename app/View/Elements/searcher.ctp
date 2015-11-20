<?
	$this->Combinator->add_libs('js', 'suggester.js');
	if( !isset($size) )
		$size = 'md';
?>
<form action="<?= @$dataBrowser['searchAction'] ? $dataBrowser['searchAction'] : '' ?>" method="get"
      class="form-horizontal suggesterBlock row">
	<? if( isset($widget) ) {?><input type="hidden" name="widget" value="true" /><? } ?>
    <div class="searcher form-group has-feedback">
        <div class="col-md-12">
            <div class="input-group">
                <input class="form-control hasclear input-<?= $size ?><? if (isset($url) && !empty($q)) {
                    echo ' clearer-on';
                } ?>"
                       placeholder="<?= isset($placeholder) ? $placeholder : 'Szukaj...'; ?>"
                       type="text"
                       name="q"
                       value="<?= $q ?>"
                       data-dataset="<?= $autocompletion ? $autocompletion['dataset'] : '*'; ?>"
                       data-url="<?= @$url ?>"
                       data-autocompletion="<?= $autocompletion ? 'true' : 'false' ?>"
                       data-searchtag='<?= $searchTag ? json_encode($searchTag) : false ?>'
                       autocomplete="<?= $autocompletion ? 'off' : 'on' ?>"
                       required
                    />
                <? if (isset($url) && !empty($q)) { ?>
                    <a class="clearer" href="<?= $url ?>">
                        <span class="form-control-feedback" aria-hidden="true">&times;</span>
                    </a>
                <? } ?>
                <div class="input-group-btn">
                    <button class="btn btn-primary input-<?= $size ?>" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
