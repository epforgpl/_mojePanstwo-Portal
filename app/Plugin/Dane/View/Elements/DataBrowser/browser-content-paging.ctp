<div class="row">
	<? if( isset($params['count']) ) { ?>
	    <div class="col-md-12">
		    <div class="dataCounter">
		        <? if($params['count']) {?><p class="pull-left"><?= pl_dopelniacz($params['count'], 'wynik', 'wyniki', 'wyników') ?></p><? } ?>
				
				<? /*
		        <p class="pull-right">
		            <a href="#" class="link-discrete link-api-call" data-toggle="modal" data-target=".modal-api-call"><span
		                    class="glyphicon glyphicon-cog"></span> API</a>
		        </p>
		        */ ?>
		        
		    </div>
	    </div>
	<? } ?>
</div>