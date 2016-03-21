<?
$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
$columns = isset($columns) ? $columns : array(10, 2);

?>
<div class="dataBrowser upper<? if (isset($class)) echo " " . $class; ?>">

    <div class="row dataBrowserContent">

	    <?= $this->element('Dane.DataBrowser/browser-content', array(
	    	'displayAggs' => $displayAggs,
	    	'columns' => $columns,
	    	'menu' => isset($menu) ? $menu : null,
            'pills' => isset($pills) ? $pills : null,
	    	'truncate' => isset($truncate) ? $truncate : null,
	    	'paginatorPhrases' => isset($paginatorPhrases) ? $paginatorPhrases : null,
	    	'afterMenuElement' => isset($afterMenuElement) ? $afterMenuElement : false,
	    )); ?>

    </div>

</div>
