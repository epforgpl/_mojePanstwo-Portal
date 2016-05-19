<?
	$this->Combinator->add_libs('css', $this->Less->css('sprawozdania_opp', array('plugin' => 'Ngo')));
	$this->Combinator->add_libs('js', 'Ngo.sprawozdania_opp');
	
	$aggs = $dataBrowser['aggs']['krs_podmioty']['sprawozdania_opp']['rocznik'];
?>

</div></div>
	
	<div class="appBanner">
        <h1 class="appTitle">Sprawozdania Organizacji Pożytku Publicznego</h1>
        <p class="appSubtitle">Sprawdź jakie przychody mają organizacje OPP w Polsce i jakie są ich źródła.</p>
    </div>
	
	<? if (isset($filter_options)) { ?>
        <div class="appSwitchers text-center">
	        <div class="container">
                <form id="dataForm" method="get">

                    <div class="row">
						
						<div class="col-sm-3">
                            <div class="form-group">
                                <label for="modeSelect">Województwo: </label>
                                <select id="modeSelect" class="form-control" name="w">
                                    <? foreach ($filter_options['w']['items'] as $i => $item) { ?>
                                        <option
                                            value="<?= $item['id'] ?>"<? if ($filter_options['w']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                            <?= $item['label'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
						
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="dataSelect">Wielkość organizacji: </label>
                                <select id="dataSelect" class="form-control" name="size">
                                    <? foreach ($filter_options['size']['items'] as $i => $item) { ?>
                                        <option
                                            value="<?= $item['id'] ?>"<? if ($filter_options['size']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                            <?= $item['label'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="rangeSelect">Analizowany rocznik: </label>
                                <select id="rangeSelect" class="form-control" name="timerange">
                                    <? foreach ($filter_options['timerange']['items'] as $i => $item) { ?>
                                        <option
                                            value="<?= $item['id'] ?>"<? if ($filter_options['timerange']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                            <?= $item['label'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            
			<p class="main_msg">Liczba analizowanych sprawozdań: <b><?= $aggs['przychody_ogolem_range']['doc_count'] ?></b></p>

            
        </div>
    <? } ?>
	
	
	
	<div id="mp-sections">
	    
	    
	    <div class="info">
		    
		    <p>W 2014 roku, organizacje pożytku publicznego uzyskały przychody:</p>
		    <p class="number"></p>
		    
		    <? debug( $aggs ); ?>
		    
	    </div>
	    
	    
        <? 
	        /*
	        $i=0; 
	        foreach( $fields as $field => $fielddata ) { 
	        	
	        	$diff = $aggs[$field . '_range']['stats']['max'] - $aggs[$field . '_range']['stats']['min'];
	        	$histogram_interval = ceil($diff / 50);
	        	
        ?>
        
            <div class="chart" data-itemid="<?= $i ?>" data-field="<?= $field ?>" data-histogram-interval="<?= $histogram_interval ?>">
	            
	            <div class="container">
	            
	                <h2><?= $fielddata['title'] ?></h2>
	                
	                <div class="row">
		                <div class="col-md-8" style="height: 245px;">
	                
			                <div class="histogram_cont">
			                    <div class="histogram" data-median="<?= $aggs[$field . '_range']['percentiles']['values']['50.0'] ?>" data-title="<?= $fielddata['title'] ?>">
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
					                        $left = round( 100 * ( $aggs[$field . '_range']['percentiles']['values']['50.0'] - $aggs[$field . '_range']['stats']['min'] ) / $diff );
			                        ?>
			                        <li class="_median" style="left: <?= $left ?>%">
			                            Mediana<br/><?= number_format_h($aggs[$field . '_range']['percentiles']['values']['50.0']) ?>
			                        </li>
			                        <? } ?>
			                        <li class="max"></li>
			                    </ul>
			                </div>
			                
		                </div><div class="col-md-4">
			                
			                <div class="block block-simple nobg block-ranking">
				                <section class="content">
					                
					                <ul>
						            <? foreach( $aggs[$field . '_range']['max']['buckets'] as $b ) {?>
						            	<li class="objectRender krs_podmioty">
						            	
								            		
						            		<span class="object-icon icon-datasets-krs_podmioty"></span>
						            		
						            		<div class="title_cont">
							            		<p class="title"><a href="/<?= $b['reverse']['top']['hits']['hits'][0]['_source']['slug'] ?>"><?= $this->Text->truncate($b['reverse']['top']['hits']['hits'][0]['_source']['data']['krs_podmioty']['nazwa'], 60) ?></a></p>
							            		<p class="value"><?= number_format_h($b['key']) ?> zł</p>
						            		</div>
								            		
							            		

						            	</li>
						            <? } ?>
					                </ul>
					                
					                <p class="text-center margin-top-10">
						                <button class="btn btn-xs btn-default">Pełny ranking...</button>
					                </p>
					                
				                </section>
			                </div>
			                
		                </div>
	                </div>
                
	            </div>
		                
            </div>
		    
        <? $i++; } */ ?>

	</div>

<div><div>