<?
	switch( $options['mode'] ) {
		case 'medium': {
?>
	<div class="row">
		<div class="col-md-12">
			
			<div class="agg" data-agg_id="stats"></div>
			
		</div><div class="col-md-12">
			
			<div class="block block-size-sm block-simple col-xs-12">
				<header>Największe umowy:</header>
				<section>
					<div class="agg" data-agg_id="dokumenty" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($options['aggs']['umowy']), ENT_QUOTES, 'UTF-8')) ?>></div>
					<div class="buttons" style="display: none;">
				        <a <?= printf('data-more="%s"', htmlspecialchars(json_encode($options['more']), ENT_QUOTES, 'UTF-8')) ?> href="#" class="btn btn-primary btn-xs btn-more">Zobacz więcej</a>
				    </div>
				</section>
				
				
			</div>
			
				        
			
		</div><div class="col-md-12">
			
			<div class="block block-size-sm block-simple col-xs-12">
				<header>Główni wykonawcy:</header>
				<section>
					<div class="agg" data-agg_id="wykonawcy" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($options['aggs']['wykonawcy']), ENT_QUOTES, 'UTF-8')) ?>></div>
				</section>
			</div>	
							
		</div>
	</div>
<?
			break;
		}
		default: {
			foreach( $options['aggs'] as $agg_id => $agg_params ) {
		?>
	        <div class="agg" data-agg_id="<?= $agg_id ?>" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($agg_params), ENT_QUOTES, 'UTF-8')) ?>></div>		        
	    <? 
		    }
		?>
			<div class="buttons" style="display: none;">
		        <a data-href="<?= $more ?>" href="<?= $more ?>" class="btn btn-primary btn-xs btn-more">Zobacz więcej</a>
		    </div>
		<?
		}
	}
?>