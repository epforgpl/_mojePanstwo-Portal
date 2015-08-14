<?
$displayAggs = isset($displayAggs) ? (boolean) $displayAggs : true;
$columns = isset($columns) ? $columns : array(8, 4);
?>
<div class="objectsPage">
	<div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
		
		<div class="searcher-app">
			<div class="container">
			    <?= $this->element('Dane.DataBrowser/browser-searcher'); ?>
			</div>
		</div>
		
		<? if( @isset($dataBrowser['aggs']['apps']['buckets']) ) {?>
		<div class="apps-menu">
			<div class="container">
			    <ul>
				    <li>
				    	<a class="active" href="/dane">Dane publiczne</a>
				    </li>
				    <? foreach($dataBrowser['aggs']['apps']['buckets'] as $b) {?>
				    <li>
				    	<a href="<?= $b['app']['href'] ?>?q=<?= urlencode($this->request->query['q']) ?>"><?= $b['app']['name'] ?></a>
				    </li>
				    <? } ?>
			    </ul>
			</div>
		</div>
		<? } ?>
				
		<div class="container">
		    <div class="row">
			
			    <?= $this->element('Dane.DataBrowser/browser-content', array(
			    	'displayAggs' => $displayAggs,
			    	'columns' => $columns,
			    )); ?>
		        
		    </div>
		</div>
	
	</div>
</div>