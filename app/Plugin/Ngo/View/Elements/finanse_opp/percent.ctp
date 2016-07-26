<div class="global_info text-center">

<?
    
    $sum = $aggs['suma.koszty_kampania_procent']['value'];
	$_sum = round( $sum );
	$sum_parts = array();
	
	$v = $_sum % 1000;
	$_sum -= $v;
	$_sum /= 1000;
	if( $v )
		array_unshift($sum_parts, pl_dopelniacz($v, 'złotych', 'złotych', 'złotych'));
	
	$v = $_sum % 1000;
	$_sum -= $v;
	$_sum /= 1000;
	if( $v )
		array_unshift($sum_parts, pl_dopelniacz($v, 'tysiąc', 'tysiące', 'tysięcy'));
		
	$v = $_sum % 1000;
	$_sum -= $v;
	$_sum /= 1000;
	if( $v )
		array_unshift($sum_parts, pl_dopelniacz($v, 'milion', 'miliony', 'milionów'));
		
	$v = $_sum % 1000;
	$_sum -= $v;
	$_sum /= 1000;
	if( $v )
		array_unshift($sum_parts, pl_dopelniacz($v, 'miliard', 'miliardy', 'miliardów'));
    
?>

<h1 class="chapter_title percent">Kampania <span data-icon="&#xe922;"></span></h1>

<h2 class="margin-top-40">Koszty kampanii informacyjnej lub reklamowej związanej z pozyskiwaniem 1% podatku dochodowego od osób fizycznych:</h2>
<p class="value"><?= implode(', ', $sum_parts) ?></p>
						
</div>

<?
	$diff = $aggs['stats.koszty_kampania_procent']['max'] - $aggs['stats.koszty_kampania_procent']['min'];
$histogram_interval = ceil($diff / 50);  
?>
<div class="histogram_chart init" data-field="koszty_kampania_procent" data-histogram-interval="<?= $histogram_interval ?>">
    
<div class="container">

    <h2>Rozkład kosztów wśród organizacji:</h2>
    
    <div class="row">
        <div class="col-md-8" style="height: 245px;">
    
            <div class="histogram_cont">
                <div class="histogram" data-median="<?= $aggs['percentiles.koszty_kampania_procent']['values']['50.0'] ?>">
                    <div class="spinner grey">
			            <div class="bounce1"></div>
			            <div class="bounce2"></div>
			            <div class="bounce3"></div>
			        </div>
                </div>
            </div>
            <div class="gradient_cont">
                <span class="gradient"></span>
                <ul class="addons">
                    <li class="min"></li>
                    <?
                        if( $diff ) {
	                        $left = round( 100 * ( $aggs['percentiles.koszty_kampania_procent']['values']['50.0'] - $aggs['stats.koszty_kampania_procent']['min'] ) / $diff );
                    ?>
                    <li class="_median" style="left: <?= $left ?>%">
                        Mediana<br/><?= number_format_h($aggs['percentiles.koszty_kampania_procent']['values']['50.0']) ?>
                    </li>
                    <? } ?>
                    <li class="max"></li>
                </ul>
            </div>
            
        </div><div class="col-md-4">
            
            <div class="block block-simple nobg block-ranking">
                <section class="content">
	                
	                <ul>
		            <? foreach( $aggs['max.koszty_kampania_procent']['buckets'] as $b ) {?>
		            	<li class="objectRender krs_podmioty">
		            	
				            		
		            		<span class="object-icon icon-datasets-krs_podmioty"></span>
		            		
		            		<div class="title_cont">
			            		<p class="title"><a href="/<?= $b['reverse']['top']['hits']['hits'][0]['_source']['slug'] ?>/sprawozdania_opp_rocznik/<?= $filter_options['timerange']['selected_id'] ?>"><?= $this->Text->truncate($b['reverse']['top']['hits']['hits'][0]['_source']['data']['krs_podmioty']['nazwa'], 60) ?></a></p>
			            		<p class="value"><?= number_format_h($b['key']) ?> zł</p>
		            		</div>
				            		
			            		

		            	</li>
		            <? } ?>
	                </ul>
	                
	                <p class="text-center margin-top-10">
		                <button class="btn btn-xs btn-default btn-rank">Pełny ranking...</button>
	                </p>
	                
                </section>
            </div>
            
        </div>
    </div>

</div>
        
</div>