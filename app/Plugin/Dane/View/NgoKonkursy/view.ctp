<?
	echo $this->Combinator->add_libs('css', $this->Less->css('ngo_konkursy', array('plugin' => 'Dane')));
?>

<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="object">
		
		<div class="row">
			<div class="col-md-9">
								
				<div class="block">
					<section class="text">
						
						<?= $object->getLayer('content'); ?>
						
					</section>
				</div>
				
			</div><div class="col-md-6">
				
			</div>
		</div>
		
        
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>