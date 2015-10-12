<?
	
$this->Combinator->add_libs('css', $this->Less->css('view-grouped-search-results', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

$map = array();
foreach( $dataBrowser['aggs'] as $agg_id => $agg_data )
	if( @$agg_data['top']['hits']['total'] )
		$map[ $agg_id ] = $agg_data['top']['hits']['max_score'];

arsort($map);
?>

<div class="col-md-9 grouped-search-results">
	
	<?
		$order = (
			isset( $this->request->query['order'] ) && 
			( $this->request->query['order'] == 'date' )
		);
	?>
	
	<ul class="pagination">
		<li<? if(!$order){?> class="active"<? } ?>><a href="?q=<?= urlencode( $this->request->query['q'] ) ?>">Sortuj według trafności</a></li>
		<li<? if($order){?> class="active"<? } ?>><a href="?q=<?= urlencode( $this->request->query['q'] ) ?>&order=date">Sortuj według dat</a></li>
	</ul>
	
	<? 
		foreach( array_keys($map) as $agg_id ) {
			
			$agg = $dataBrowser['aggs'][$agg_id];
				
	?>
	
		    <div class="block block-simple block-size-sm col-xs-12">
		        <header><?= $aggs_dictionary[$agg_id]['title'] ?></header>
		
		        <section class="aggs-init">
		            <div class="dataAggs">
		                <div class="agg agg-Dataobjects">
		                    <? if ($agg['top']['hits']['hits']) { ?>
		                        <ul class="dataobjects">
		                            <? foreach ($agg['top']['hits']['hits'] as $doc) { ?>
		                                <li>
		                                    <?
		                                    echo $this->Dataobject->render($doc, 'default');
		                                    ?>
		                                </li>
		                            <? } ?>
		                        </ul>
		                        <div class="buttons">
		                            <a href="<?= $aggs_dictionary[$agg_id]['href'] ?>?q=<?= @$this->request->query['q'] ?>" class="btn btn-primary btn-xs">Zobacz więcej</a>
		                        </div>
		                    <? } ?>
		
		                </div>
		            </div>
		        </section>
		    </div>
    
    <? } ?>  

</div>