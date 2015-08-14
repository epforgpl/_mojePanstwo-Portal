<?
$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
$columns = isset($columns) ? $columns : array(8, 4);
?>
<div class="dataBrowser<? if (isset($class)) echo " " . $class; ?>">

    <?= $this->element('Dane.DataBrowser/browser-searcher'); ?>

    <div class="row">
	
	    <?= $this->element('Dane.DataBrowser/browser-content', array(
	    	'displayAggs' => $displayAggs,
	    	'columns' => $columns,
	    )); ?>
        
    </div>

</div>