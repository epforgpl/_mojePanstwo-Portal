<?
$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);
?>
<div class="dataBrowser<? if (isset($class)) echo " " . $class; ?>">

    <?= $this->element('Dane.DataBrowser/browser-searcher'); ?>
		
    <div class="row dataBrowserContent">
				
	    <?= $this->element('Dane.DataBrowser/browser-content', array(
	    	'displayAggs' => $displayAggs,
	    	'columns' => $columns,
	    	'menu' => isset($menu) ? $menu : null,
	    	'truncate' => isset($truncate) ? $truncate : null,
	    )); ?>
        
    </div>

</div>