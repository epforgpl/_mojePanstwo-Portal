<?
	
	$adresat_id = false;
	
	if( isset($adresat) ) {
		
		$adresat_id = $adresat;
		
	} elseif( $object ) {
		
		$adresat_id = $object->getDataset() . ':' . $object->getId();
		
	}
		
?>

<div class="banner pismo block">
    <?php echo $this->Html->image('Dane.banners/pisma.svg', array('width' => '92', 'alt' => 'Stwórz pismo do organizacji', 'class' => 'pull-right')); ?>
    <p><?= isset($label) ? $label : '<strong>Wyślij pismo</strong> do tej organizacji'; ?></p>
    <a href="/pisma/nowe" class="btn btn-sm btn-primary pisma-list-button" data-adresatid="<?= $adresat_id ?>">Napisz
        pismo</a>
</div>