<div class="row">
	<? if( isset($params['count']) ) { ?>
	    <div class="col-md-12">
		    <div class="dataCounter">
		        <? if($params['count']) {?><p class="pull-left"><?= pl_dopelniacz($params['count'], 'wynik', 'wyniki', 'wyników') ?></p><? } ?>
		    </div>
	    </div>
	<? } ?>
</div>
