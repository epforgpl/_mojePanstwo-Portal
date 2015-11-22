<?
$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);
?>
<div class="dataBrowser<? if (isset($class)) echo " " . $class; ?>">

    <div class="row dataBrowserContent">

	    <?= $this->element('Dane.DataBrowser/browser-content', array(
	    	'displayAggs' => $displayAggs,
	    	'columns' => $columns,
	    	'menu' => isset($menu) ? $menu : null,
            'pills' => isset($pills) ? $pills : null,
	    	'truncate' => isset($truncate) ? $truncate : null,
	    	'paginatorPhrases' => isset($paginatorPhrases) ? $paginatorPhrases : null,
	    )); ?>

    </div>

</div>
