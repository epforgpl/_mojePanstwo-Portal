<?
	
	$this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
?>
    
    <div class="banner mapy block">
	    <?php echo $this->Html->image('Dane.banners/pisma.svg', array('width' => '92', 'alt' => 'Stwórz pismo do organizacji', 'class' => 'pull-right')); ?>
	    <p><b>Zobacz plany inwestycyjne</b> na mapie</p>
	    <button class="btn btn-primary btn-sm">Otwórz mapę</button>
	</div>