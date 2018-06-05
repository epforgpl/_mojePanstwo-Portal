<?
	switch( $options['mode'] ) {
		case 'medium': {
?>
	<div class="row">
		<div class="col-md-12">
			
			<div class="agg" data-agg_id="stats"></div>
			
		</div><div class="col-md-12">
			
			<div class="block block-size-sm block-simple col-xs-12 margin-top-15">
				<header>Największe umowy:</header>
				<section class="margin-sides-10">
					<div class="agg" data-agg_id="dokumenty" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($options['aggs']['umowy']), ENT_QUOTES, 'UTF-8')) ?>></div>
					
				</section>
				<div class="buttons" style="display: none;">
			        <a <?= printf('data-more="%s"', htmlspecialchars(json_encode($options['more']), ENT_QUOTES, 'UTF-8')) ?> href="#" class="btn btn-default btn-xs btn-more">Zobacz więcej</a>
			    </div>
				
			</div>
			
				        
			
		</div><div class="col-md-12">
			
			<div class="block block-size-sm block-simple col-xs-12 margin-top-15">
				<header>Główni wykonawcy:</header>
				<section class="margin-sides-10">
					<div class="agg" data-agg_id="wykonawcy" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($options['aggs']['wykonawcy']), ENT_QUOTES, 'UTF-8')) ?>></div>
				</section>
			</div>	
							
		</div><div class="col-md-12">
			
			<div class="row">
				<div class="col-md-6">
					<div class="block block-size-sm block-simple col-xs-12 margin-top-15">
						<header>Rodzaje umów według budżetu:</header>
						<section class="margin-sides-10">
							<div class="agg" data-agg_id="rodzaje_budzet" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($options['aggs']['rodzaje_budzet']), ENT_QUOTES, 'UTF-8')) ?>></div>
						</section>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="block block-size-sm block-simple col-xs-12 margin-top-15">
						<header>Rodzaje umów według liczby:</header>
						<section class="margin-sides-10">
							<div class="agg" data-agg_id="rodzaje_wolumen" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($options['aggs']['rodzaje_wolumen']), ENT_QUOTES, 'UTF-8')) ?>></div>
						</section>
					</div>	
				</div>
			</div>
										
		</div><div class="col-md-12">
			
			<div class="row">
				<div class="col-md-6">
					<div class="block block-size-sm block-simple col-xs-12 margin-top-15">
						<header>Jednostki zawierające umowy:</header>
						<section class="margin-sides-10">
							<div class="agg" data-agg_id="jednostki" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($options['aggs']['jednostki']), ENT_QUOTES, 'UTF-8')) ?>></div>
						</section>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="block block-size-sm block-simple col-xs-12 margin-top-15">
						<header>Tryby zawierania umów:</header>
						<section class="margin-sides-10">
							<div class="agg" data-agg_id="tryby" <? printf('data-agg_params="%s"', htmlspecialchars(json_encode($options['aggs']['tryby']), ENT_QUOTES, 'UTF-8')) ?>></div>
						</section>
					</div>	
				</div>
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
		        <a data-href="<?= $more ?>" href="<?= $more ?>" class="btn btn-default btn-xs btn-more">Zobacz więcej</a>
		    </div>
		<?
		}
	}
?>