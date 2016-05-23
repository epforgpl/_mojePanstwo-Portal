<?
	$this->Combinator->add_libs('css', $this->Less->css('finanse_opp', array('plugin' => 'Ngo')));
	$this->Combinator->add_libs('js', 'Ngo.finanse_opp');
	
	$aggs = $dataBrowser['aggs']['krs_podmioty']['sprawozdania_opp']['rocznik'];
	
	$sum = $aggs['suma.przychody_ogolem']['value'];
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
            
            

            
        </div>
    <? } ?>
	
	
	
	<div id="mp-sections">
	    
	    <div class="global_info text-center margin-top-20">
		    
		    <h2>Suma uzyskanych przychodów:</h2>
		    <p class="value"><?= implode(', ', $sum_parts) ?></p>
			<p class="main_msg">Liczba analizowanych sprawozdań: <b><?= $aggs['doc_count'] ?></b></p>
			
			<?
				if( $filter_options['timerange']['selected_id']==2015 ) {
			?>
			<div class="container">
				<div class="alert alert-danger margin-top-20">
					<p>Sprawozdania za rok 2015 są niekompletne. Termin składania sprawozdań jeszcze się nie zakończył.</p>
				</div>
			</div>
			<?
				}
			?>
			
	    </div>
	    
	   	<?
		   	$diff = $aggs['stats.przychody_ogolem']['max'] - $aggs['stats.przychody_ogolem']['min'];
			$histogram_interval = ceil($diff / 50);  
		?>
	    <div class="histogram_chart init" data-field="przychody_ogolem" data-histogram-interval="<?= $histogram_interval ?>">
	            
            <div class="container">
            
                <h2>Rozkład przychodów wśród organizacji:</h2>
                
                <div class="row">
	                <div class="col-md-8" style="height: 245px;">
                
		                <div class="histogram_cont">
		                    <div class="histogram" data-median="<?= $aggs['percentiles.przychody_ogolem']['values']['50.0'] ?>">
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
				                        $left = round( 100 * ( $aggs['percentiles.przychody_ogolem']['values']['50.0'] - $aggs['stats.przychody_ogolem']['min'] ) / $diff );
		                        ?>
		                        <li class="_median" style="left: <?= $left ?>%">
		                            Mediana<br/><?= number_format_h($aggs['percentiles.przychody_ogolem']['values']['50.0']) ?>
		                        </li>
		                        <? } ?>
		                        <li class="max"></li>
		                    </ul>
		                </div>
		                
	                </div><div class="col-md-4">
		                
		                <div class="block block-simple nobg block-ranking">
			                <section class="content">
				                
				                <ul>
					            <? foreach( $aggs['max.przychody_ogolem']['buckets'] as $b ) {?>
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
	    
	    
	    
	    <div class="container">
		    <div id="charts" class="row">
			    <div id="chart-income-sources" class="col-md-6">
				    
				    <h2>Przychody według źródeł:</h2>
				    
				    <div class="chart"></div>
				    <div class="chart_description">
					    <ul>
						    <li>
						    	<a class="item" href="#" data-field="przychody_zrodla_publiczne" data-value="<?= $aggs['suma.przychody_zrodla_publiczne']['value'] ?>" data-color="#C42419">
							    	<p class="_color" style="background-color: #C42419;"></p>
							    	<p class="_label">Przychody ze źródeł publicznych</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_zrodla_publiczne']['value']) ?></p>
						    	</a>
						    	<ul>
							    	<li>
								    	<a class="item" href="#" data-field="przychody_samorzad" data-value="<?= $aggs['suma.przychody_samorzad']['value'] ?>">
									    	<p class="_color"></p>
									    	<p class="_label">Przychody ze środków budżetu samorządu terytorialnego</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_samorzad']['value']) ?></p>
								    	</a>
								    </li>
								     <li>
								    	<a class="item" href="#" data-field="przychody_budzet_panstwa" data-value="<?= $aggs['suma.przychody_budzet_panstwa']['value'] ?>">
									    	<p class="_color"></p>
									    	<p class="_label">Przychody ze środków budżetu państwa</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_budzet_panstwa']['value']) ?></p>
								    	</a>
								    </li>
							    	<li>
							    		<a class="item" href="#" data-field="przychody_srodki_europejskie" data-value="<?= $aggs['suma.przychody_srodki_europejskie']['value'] ?>">
								    		<p class="_color"></p>
									    	<p class="_label">Przychody ze środków europejskich</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_srodki_europejskie']['value']) ?></p>
							    		</a>
								    </li>								    
								    <li>
									    <a class="item" href="#" data-field="przychody_fundusze_celowe" data-value="<?= $aggs['suma.przychody_fundusze_celowe']['value'] ?>">
										    <p class="_color"></p>
									    	<p class="_label">Przychody ze środków państwowych funduszy celowych</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_fundusze_celowe']['value']) ?></p>
									    </a>
								    </li>
						    	</ul>
						    </li>
						    <li>
						    	<a class="item" href="#" data-field="przychody_prywatne_ogolem" data-value="<?= $aggs['suma.przychody_prywatne_ogolem']['value'] ?>" data-color="#2D8E49">
							    	<p class="_color" style="background-color: #2D8E49;"></p>
							    	<p class="_label">Przychody ze źródeł prywatnych</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_prywatne_ogolem']['value']) ?></p>
						    	</a>
						    	<ul>
							    	<li>
							    		<a class="item" href="#" data-field="przychody_skladki" data-value="<?= $aggs['suma.przychody_skladki']['value'] ?>">
								    		<p class="_color"></p>
									    	<p class="_label">Przychody ze składek członkowskich</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_skladki']['value']) ?></p>
							    		</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_darowizny_osoby_fizyczne" data-value="<?= $aggs['suma.przychody_darowizny_osoby_fizyczne']['value'] ?>">
									    	<p class="_color"></p>
									    	<p class="_label">Przychody z darowizn od osób fizycznych</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_darowizny_osoby_fizyczne']['value']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_darowizny_osoby_prawne" data-value="<?= $aggs['suma.przychody_darowizny_osoby_prawne']['value'] ?>">
									    	<p class="_color"></p>
									    	<p class="_label">Przychody z darowizn od osób prawnych</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_darowizny_osoby_prawne']['value']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_ofiarnosc_publiczna" data-value="<?= $aggs['suma.przychody_ofiarnosc_publiczna']['value'] ?>">
									    	<p class="_color"></p>
									    	<p class="_label">Przychody z ofiarności publicznej (zbiórek publicznych, kwest)</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_ofiarnosc_publiczna']['value']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_majatek" data-value="<?= $aggs['suma.przychody_majatek']['value'] ?>">
									    	<p class="_color"></p>
									    	<p class="_label">Przychody z wpływów z majątku</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_majatek']['value']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_spadki_zapisy" data-value="<?= $aggs['suma.przychody_spadki_zapisy']['value'] ?>">
									    	<p class="_color"></p>
									    	<p class="_label">Przychody ze spadków, zapisów</p>
									    	<p class="_value"><?= number_format_h($aggs['suma.przychody_spadki_zapisy']['value']) ?></p>
								    	</a>
								    </li>
						    	</ul>
						    </li>
						    <li>
						    	<a class="item" href="#" data-field="przychody_procent" data-value="<?= $aggs['suma.przychody_procent']['value'] ?>" data-color="#3E55B2">
							    	<p class="_color" style="background-color: #3E55B2;"></p>
							    	<p class="_label">Przychody z 1% podatku dochodowego od osób fizycznych</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_procent']['value']) ?></p>
						    	</a>
						    </li>
						    <li>
						    	<a class="item" href="#" data-field="przychody_inne" data-value="<?= $aggs['suma.przychody_inne']['value'] ?>" data-color="#E0AF4E">
							    	<p class="_color" style="background-color: #E0AF4E;"></p>
							    	<p class="_label">Inne źródła</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_inne']['value']) ?></p>
						    	</a>
						    </li>
					    </ul>
				    </div>
				    
			    </div><div id="chart-income-types" class="col-md-6">
				    
				    <h2>Przychody według typu:</h2>
				    
				    <div class="chart"></div>
				    <div class="chart_description">
					    <ul>
						    <li>
						    	<a class="item" href="#" data-field="przychody_dzialalnosc_nieodplatna_pozytku_publicznego" data-value="<?= $aggs['suma.przychody_dzialalnosc_nieodplatna_pozytku_publicznego']['value'] ?>" data-color="#2D8E49">
							    	<p class="_color" style="background-color: #2D8E49;"></p>
							    	<p class="_label">Przychody z działalności nieodpłatnej pożytku publicznego</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_dzialalnosc_nieodplatna_pozytku_publicznego']['value']) ?></p>
						    	</a>
						    </li>
						    <li>
						    	<a class="item" href="#" data-field="przychody_pozostale" data-value="<?= $aggs['suma.przychody_pozostale']['value'] ?>" data-color="#E0AF4E">
							    	<p class="_color" style="background-color: #E0AF4E;"></p>
							    	<p class="_label">Pozostałe przychody</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_pozostale']['value']) ?></p>
						    	</a>
						    </li>
						    <li>
						    	<a class="item" href="#" data-field="przychody_dzialalnosc_odplatna_pozytku_publicznego" data-value="<?= $aggs['suma.przychody_dzialalnosc_odplatna_pozytku_publicznego']['value'] ?>" data-color="#3E55B2">
							    	<p class="_color" style="background-color: #3E55B2;"></p>
							    	<p class="_label">Przychody z działalności odpłatnej pożytku publicznego</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_dzialalnosc_odplatna_pozytku_publicznego']['value']) ?></p>
						    	</a>
						    </li>
						    <li>
						    	<a class="item" href="#" data-field="przychody_dzialalnosc_gospodarcza" data-value="<?= $aggs['suma.przychody_dzialalnosc_gospodarcza']['value'] ?>" data-color="#C42419">
							    	<p class="_color" style="background-color: #C42419;"></p>
							    	<p class="_label">Przychody z działalności gospodarczej</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_dzialalnosc_gospodarcza']['value']) ?></p>
						    	</a>
						    </li>
						    <li>
						    	<a class="item" href="#" data-field="przychody_finansowe" data-value="<?= $aggs['suma.przychody_finansowe']['value'] ?>" data-color="#A14AB2">
							    	<p class="_color" style="background-color: #A14AB2;"></p>
							    	<p class="_label">Przychody finansowe</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.przychody_finansowe']['value']) ?></p>
						    	</a>
						    </li>
					    </ul>
				    </div>
				    
			    </div>
		    </div>
	    </div>
	    
	    
	    <div id="chart-dynamic" class="histogram_chart" style="display: none;">
	            
            <div class="container">
            
                <h2></h2>
                
                <div class="row">
	                <div class="col-md-8" style="height: 245px;">
                
		                <div class="histogram_cont">
		                    <div class="histogram"></div>
		                </div>
		                <div class="gradient_cont">
		                    <span class="gradient"></span>
		                    <ul class="addons">
		                        <li class="min"></li>
		                        <li class="_median" style="display: none;"></li>
		                        <li class="max"></li>
		                    </ul>
		                </div>
		                
	                </div><div class="col-md-4">
		                
		                <div class="block block-simple nobg block-ranking">
			                <section class="content">
				                
				                <ul></ul>
				                
				                <p class="text-center margin-top-10">
					                <button class="btn btn-xs btn-default">Pełny ranking...</button>
				                </p>
				                
			                </section>
		                </div>
		                
	                </div>
                </div>
            
            </div>
	                
        </div>
        

	</div>

<div><div>