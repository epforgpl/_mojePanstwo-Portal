<?
	echo $this->Combinator->add_libs('css', $this->Less->css('ngo_konkursy', array('plugin' => 'Dane')));
?>

<?= $this->Element('dataobject/pageBegin'); ?>

    
		
		<div class="row">
			<div class="col-md-9">
				
				
				<div class="img-block-cont margin-top--10">
					<img src="<?= $object->getPageThumbnailUrl() ?>" />
				</div>
					
				<div class="block after-img">
					<section class="text">
						<div class="text-typo">
							<?= $object->getLayer('content'); ?>
						</div>
					</section>					
				</div>
				
				<div class="text-center margin-top-5 margin-bottom-20">
					<a class="btn btn-primary" target="_blank" href="<?= $object->getData('url') ?>">Zobacz więcej &raquo;</a>
				</div>
				
			</div><div class="col-md-3">
				
				<ul class="dataHighlights overflow-auto margin-sides-0 margin-top--20">
				    
				    <? if( $v = $object->getData('data') ) { ?>
	                    <li class="dataHighlight col-xs-12">
				            <p class="_label">Data publikacji</p>
				            <p class="_value"><?= dataSlownie( $v ) ?></p>
				        </li>
				    <? } ?>
				    
				    <? if( $v = $object->getData('data_deadline') ) { ?>
	                    <li class="dataHighlight col-xs-12">
				            <p class="_label">Zakończenie naboru</p>
				            <p class="_value"><?= dataSlownie( $v ) ?></p>
				        </li>
				    <? } ?>
				    
	        	</ul>
	        	
	        		        	
	        	<div class="margin-top-20">
		        	<p class="_src text-left"><a href="<?= $object->getData('url') ?>" target="_blank"><span class="glyphicon glyphicon-link"></span> Źródło</a></p>
	        	</div>
				
			</div>
		</div>
		
        

<?= $this->Element('dataobject/pageEnd'); ?>