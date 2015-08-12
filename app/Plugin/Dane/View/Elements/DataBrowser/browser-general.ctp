<div class="objectsPage">
    <?        
		$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
		$columns = isset($columns) ? $columns : array(8, 4);
	?>
	
	<div class="margin-top-0 dataBrowser<? if (isset($class)) echo " " . $class; ?>">
		
	    <?= $this->element('DataBrowser/browser-modal'); ?>
	    <?= $this->element('DataBrowser/browser-searcher-tools'); ?>

		<div class="container">
			<?= $this->element('DataBrowser/browser-content', array(
				'displayAggs' => $displayAggs,
				'columns' => $columns,
			)); ?>		
		</div>
	
	</div>
    
    ?>
</div>
