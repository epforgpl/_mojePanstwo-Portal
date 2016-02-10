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

$total_count = 0;
foreach( $dataBrowser['aggs'] as $k => $v )
	if( @$v['doc_count'] )
		$total_count += $v['doc_count'];

?>

<div class="row">
	<div class="col-md-9 grouped-search-results">
		
		<div class="appBanner margin-top--10 margin-bottom-30">
			<form method="get" action="">
		        <div class="appSearch form-group">
					<div class="input-group">
						<input<? if( isset($this->request->query['q']) ) {?> value="<?= $this->request->query['q'] ?>"<? } ?> name="q" class="form-control" placeholder="Szukaj..." type="text">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary input-md">
		                        <span class="glyphicon glyphicon-search"></span>
		                    </button>
						</span>
					</div>
		        </div>
			</form>
		</div>
		
		<?= $this->element('Dane.DataBrowser/browser-content-filters', array(
	        'paging' => array(
		        'count' => $total_count,
	        ),
	        // 'paginatorPhrases' => isset($paginatorPhrases) ? $paginatorPhrases : false,
	        // 'nopaging' => isset($nopaging) ? (boolean) $nopaging : false,
	        'searcher' => true,
	        'class' => 'margin-top-0',
	    )) ?>
		
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
			                        <ul class="dataobjects margin-sides-10">
			                            <? foreach ($agg['top']['hits']['hits'] as $doc) { ?>
			                                <li>
			                                    <?
			                                    echo $this->Dataobject->render($doc, 'default');
			                                    ?>
			                                </li>
			                            <? } ?>
			                        </ul>
			                        <div class="buttons">
			                            <a href="<?= $aggs_dictionary[$agg_id]['href'] ?>?q=<?= @$this->request->query['q'] ?>" class="btn btn-default btn-xs">Zobacz więcej</a>
			                        </div>
			                    <? } ?>
			
			                </div>
			            </div>
			        </section>
			    </div>
	    
	    <? } ?>  
	
	</div>
</div>