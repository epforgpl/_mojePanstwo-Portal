<?
	$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
	$columns = isset($columns) ? $columns : array(8, 4);
?>

<div class="dataBrowser<? if (isset($class)) echo " " . $class; ?>">

    <?= $this->element('DataBrowser/browser-modal'); ?>
    <?= $this->element('DataBrowser/browser-searcher'); ?>
	<?= $this->element('DataBrowser/browser-content', array(
		'displayAggs' => $displayAggs,
		'columns' => $columns,
	)); ?>

</div>