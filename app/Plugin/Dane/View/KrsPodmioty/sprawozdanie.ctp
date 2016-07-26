<?

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('css', $this->Less->css('view-krs-sprawozdania_opp', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-sprawozdania_opp');

$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

$sprawozdanie->setOptions(array(
	'view' => 'from_parent',
));
		
?>


<div class="row">
	<div class="col-md-2">
		<div class="dataBrowser">
		<?
			echo $this->Element('Dane.DataBrowser/browser-menu', array(
                'menu' => $_submenu,
            ));
        ?>
		</div>
	</div>
	<div class="col-md-10 nocontainer">
		
		<div id="sprawozdania_opp" class="margin-top-10">
			
			<? 
				if( $data = @$object_aggs['organizacja-sprawozdania_opp']['rocznik']['top']['hits']['hits'][0]['_source']) { 
					
					$sum = $data['przychody_ogolem'];
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
						
					$przychody_parts = $sum_parts;
					
					
					
					
					
					$sum = $data['koszty_ogolem'];
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
					
					$koszty_parts = $sum_parts;
					
					
					
					
					
					$sum = $data['koszty_kampania_procent'];
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
					
					$procent_parts = $sum_parts;
						
			?>
			
			<div class="block">
				<header>Przychody w <?= $sprawozdanie->getData('rocznik') ?> roku:</header>
				<section class="content">
					
					<div class="global_info text-center margin-top-10">
					    <p class="value"><?= implode(', ', $przychody_parts) ?></p>
					</div>
					
					<div class="charts row">
					    <div id="chart-income-sources" class="col-md-6">
						    
						    <h2>Przychody według źródeł:</h2>
						    
						    <div class="chart"></div>
						    <div class="chart_description">
							    <ul>
								    <li>
								    	<a class="item" href="#" data-field="przychody_zrodla_publiczne" data-value="<?= $data['przychody_zrodla_publiczne'] ?>" data-color="#C42419">
									    	<p class="_color" style="background-color: #C42419;"></p>
									    	<p class="_label">Przychody ze źródeł publicznych</p>
									    	<p class="_value"><?= number_format_h($data['przychody_zrodla_publiczne']) ?></p>
								    	</a>
								    	<ul>
									    	<li>
										    	<a class="item" href="#" data-field="przychody_samorzad" data-value="<?= $data['przychody_samorzad'] ?>">
											    	<p class="_color"></p>
											    	<p class="_label">Przychody ze środków budżetu samorządu terytorialnego</p>
											    	<p class="_value"><?= number_format_h($data['przychody_samorzad']) ?></p>
										    	</a>
										    </li>
										     <li>
										    	<a class="item" href="#" data-field="przychody_budzet_panstwa" data-value="<?= $data['przychody_budzet_panstwa'] ?>">
											    	<p class="_color"></p>
											    	<p class="_label">Przychody ze środków budżetu państwa</p>
											    	<p class="_value"><?= number_format_h($data['przychody_budzet_panstwa']) ?></p>
										    	</a>
										    </li>
									    	<li>
									    		<a class="item" href="#" data-field="przychody_srodki_europejskie" data-value="<?= $data['przychody_srodki_europejskie'] ?>">
										    		<p class="_color"></p>
											    	<p class="_label">Przychody ze środków europejskich</p>
											    	<p class="_value"><?= number_format_h($data['przychody_srodki_europejskie']) ?></p>
									    		</a>
										    </li>								    
										    <li>
											    <a class="item" href="#" data-field="przychody_fundusze_celowe" data-value="<?= $data['przychody_fundusze_celowe'] ?>">
												    <p class="_color"></p>
											    	<p class="_label">Przychody ze środków państwowych funduszy celowych</p>
											    	<p class="_value"><?= number_format_h($data['przychody_fundusze_celowe']) ?></p>
											    </a>
										    </li>
								    	</ul>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_prywatne_ogolem" data-value="<?= $data['przychody_prywatne_ogolem'] ?>" data-color="#2D8E49">
									    	<p class="_color" style="background-color: #2D8E49;"></p>
									    	<p class="_label">Przychody ze źródeł prywatnych</p>
									    	<p class="_value"><?= number_format_h($data['przychody_prywatne_ogolem']) ?></p>
								    	</a>
								    	<ul>
									    	<li>
									    		<a class="item" href="#" data-field="przychody_skladki" data-value="<?= $data['przychody_skladki'] ?>">
										    		<p class="_color"></p>
											    	<p class="_label">Przychody ze składek członkowskich</p>
											    	<p class="_value"><?= number_format_h($data['przychody_skladki']) ?></p>
									    		</a>
										    </li>
										    <li>
										    	<a class="item" href="#" data-field="przychody_darowizny_osoby_fizyczne" data-value="<?= $data['przychody_darowizny_osoby_fizyczne'] ?>">
											    	<p class="_color"></p>
											    	<p class="_label">Przychody z darowizn od osób fizycznych</p>
											    	<p class="_value"><?= number_format_h($data['przychody_darowizny_osoby_fizyczne']) ?></p>
										    	</a>
										    </li>
										    <li>
										    	<a class="item" href="#" data-field="przychody_darowizny_osoby_prawne" data-value="<?= $data['przychody_darowizny_osoby_prawne'] ?>">
											    	<p class="_color"></p>
											    	<p class="_label">Przychody z darowizn od osób prawnych</p>
											    	<p class="_value"><?= number_format_h($data['przychody_darowizny_osoby_prawne']) ?></p>
										    	</a>
										    </li>
										    <li>
										    	<a class="item" href="#" data-field="przychody_ofiarnosc_publiczna" data-value="<?= $data['przychody_ofiarnosc_publiczna'] ?>">
											    	<p class="_color"></p>
											    	<p class="_label">Przychody z ofiarności publicznej (zbiórek publicznych, kwest)</p>
											    	<p class="_value"><?= number_format_h($data['przychody_ofiarnosc_publiczna']) ?></p>
										    	</a>
										    </li>
										    <li>
										    	<a class="item" href="#" data-field="przychody_majatek" data-value="<?= $data['przychody_majatek'] ?>">
											    	<p class="_color"></p>
											    	<p class="_label">Przychody z wpływów z majątku</p>
											    	<p class="_value"><?= number_format_h($data['przychody_majatek']) ?></p>
										    	</a>
										    </li>
										    <li>
										    	<a class="item" href="#" data-field="przychody_spadki_zapisy" data-value="<?= $data['przychody_spadki_zapisy'] ?>">
											    	<p class="_color"></p>
											    	<p class="_label">Przychody ze spadków, zapisów</p>
											    	<p class="_value"><?= number_format_h($data['przychody_spadki_zapisy']) ?></p>
										    	</a>
										    </li>
								    	</ul>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_procent" data-value="<?= $data['przychody_procent'] ?>" data-color="#3E55B2">
									    	<p class="_color" style="background-color: #3E55B2;"></p>
									    	<p class="_label">Przychody z 1% podatku dochodowego od osób fizycznych</p>
									    	<p class="_value"><?= number_format_h($data['przychody_procent']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_inne" data-value="<?= $data['przychody_inne'] ?>" data-color="#E0AF4E">
									    	<p class="_color" style="background-color: #E0AF4E;"></p>
									    	<p class="_label">Inne źródła</p>
									    	<p class="_value"><?= number_format_h($data['przychody_inne']) ?></p>
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
								    	<a class="item" href="#" data-field="przychody_dzialalnosc_nieodplatna_pozytku_publicznego" data-value="<?= $data['przychody_dzialalnosc_nieodplatna_pozytku_publicznego'] ?>" data-color="#2D8E49">
									    	<p class="_color" style="background-color: #2D8E49;"></p>
									    	<p class="_label">Przychody z działalności nieodpłatnej pożytku publicznego</p>
									    	<p class="_value"><?= number_format_h($data['przychody_dzialalnosc_nieodplatna_pozytku_publicznego']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_pozostale" data-value="<?= $data['przychody_pozostale'] ?>" data-color="#E0AF4E">
									    	<p class="_color" style="background-color: #E0AF4E;"></p>
									    	<p class="_label">Pozostałe przychody</p>
									    	<p class="_value"><?= number_format_h($data['przychody_pozostale']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_dzialalnosc_odplatna_pozytku_publicznego" data-value="<?= $data['przychody_dzialalnosc_odplatna_pozytku_publicznego'] ?>" data-color="#3E55B2">
									    	<p class="_color" style="background-color: #3E55B2;"></p>
									    	<p class="_label">Przychody z działalności odpłatnej pożytku publicznego</p>
									    	<p class="_value"><?= number_format_h($data['przychody_dzialalnosc_odplatna_pozytku_publicznego']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_dzialalnosc_gospodarcza" data-value="<?= $data['przychody_dzialalnosc_gospodarcza'] ?>" data-color="#C42419">
									    	<p class="_color" style="background-color: #C42419;"></p>
									    	<p class="_label">Przychody z działalności gospodarczej</p>
									    	<p class="_value"><?= number_format_h($data['przychody_dzialalnosc_gospodarcza']) ?></p>
								    	</a>
								    </li>
								    <li>
								    	<a class="item" href="#" data-field="przychody_finansowe" data-value="<?= $data['przychody_finansowe'] ?>" data-color="#A14AB2">
									    	<p class="_color" style="background-color: #A14AB2;"></p>
									    	<p class="_label">Przychody finansowe</p>
									    	<p class="_value"><?= number_format_h($data['przychody_finansowe']) ?></p>
								    	</a>
								    </li>
							    </ul>
						    </div>
						    
					    </div>
				    </div>
					
				</section>
			</div>
			
			<div class="block">
				<header>Koszty w <?= $sprawozdanie->getData('rocznik') ?> roku:</header>
				<section class="content">
					
					<div class="global_info text-center">
					    <p class="value"><?= implode(', ', $koszty_parts) ?></p>
					</div>
					
					<div class="charts row">
					    <div id="chart-outcome-types" class="col-md-10 col-md-offset-1">
						    
						    <h2>Koszty według typów:</h2>
						    
						    <div class="chart"></div>
							    <div class="chart_description">
								    <ul>
									    <li>
									    	<a class="item" href="#" data-field="koszty_dzialalnosc_nieodplatna_pozytku_publicznego" data-value="<?= $data['koszty_dzialalnosc_nieodplatna_pozytku_publicznego'] ?>" data-color="#C42419">
										    	<p class="_color" style="background-color: #C42419;"></p>
										    	<p class="_label">Koszty prowadzenia nieodpłatnej działalności pożytku publicznego</p>
										    	<p class="_value"><?= number_format_h($data['koszty_dzialalnosc_nieodplatna_pozytku_publicznego']) ?></p>
									    	</a>
									    	<ul>
										    	<li>
											    	<a class="item" href="#" data-field="koszty_dzialalnosc_nieodplatna_pozytku_publicznego_procent" data-value="<?= $data['koszty_dzialalnosc_nieodplatna_pozytku_publicznego_procent'] ?>">
												    	<p class="_color"></p>
												    	<p class="_label">W tym finansowane z 1% podatku dochodowego od osób fizycznych</p>
												    	<p class="_value"><?= number_format_h($data['koszty_dzialalnosc_nieodplatna_pozytku_publicznego_procent']) ?></p>
											    	</a>
											    </li>
									    	</ul>
									    </li>
									    <li>
									    	<a class="item" href="#" data-field="koszty_dzialalnosc_odplatna_pozytku_publicznego" data-value="<?= $data['koszty_dzialalnosc_odplatna_pozytku_publicznego'] ?>" data-color="#2D8E49">
										    	<p class="_color" style="background-color: #2D8E49;"></p>
										    	<p class="_label">Koszty prowadzenia odpłatnej działalności pożytku publicznego</p>
										    	<p class="_value"><?= number_format_h($data['koszty_dzialalnosc_odplatna_pozytku_publicznego']) ?></p>
									    	</a>
									    	<ul>
										    	<li>
											    	<a class="item" href="#" data-field="koszty_dzialalnosc_odplatna_pozytku_publicznego_procent" data-value="<?= $data['koszty_dzialalnosc_odplatna_pozytku_publicznego_procent'] ?>">
												    	<p class="_color"></p>
												    	<p class="_label">W tym finansowane z 1% podatku dochodowego od osób fizycznych</p>
												    	<p class="_value"><?= number_format_h($data['koszty_dzialalnosc_odplatna_pozytku_publicznego_procent']) ?></p>
											    	</a>
											    </li>
									    	</ul>
									    </li>
									    <li>
									    	<a class="item" href="#" data-field="koszty_pozostale_ogolem" data-value="<?= $data['koszty_pozostale_ogolem'] ?>" data-color="#3E55B2">
										    	<p class="_color" style="background-color: #3E55B2;"></p>
										    	<p class="_label">Pozostałe koszty ogółem</p>
										    	<p class="_value"><?= number_format_h($data['koszty_pozostale_ogolem']) ?></p>
									    	</a>
									    	<ul>		    
											    <li>
											    	<a class="item" href="#" data-field="koszty_pozostale_ogolem_procent" data-value="<?= $data['koszty_pozostale_ogolem_procent'] ?>">
												    	<p class="_color"></p>
												    	<p class="_label">W tym finansowane z 1% podatku dochodowego od osób fizycznych</p>
												    	<p class="_value"><?= number_format_h($data['koszty_pozostale_ogolem_procent']) ?></p>
											    	</a>
											    </li>
										    </ul>
									    </li>
									    <li>
									    	<a class="item" href="#" data-field="koszty_dzialalnosc_gospodarcza" data-value="<?= $data['koszty_dzialalnosc_gospodarcza'] ?>" data-color="#E0AF4E">
										    	<p class="_color" style="background-color: #E0AF4E;"></p>
										    	<p class="_label">Koszty prowadzenia działalności gospodarczej</p>
										    	<p class="_value"><?= number_format_h($data['koszty_dzialalnosc_gospodarcza']) ?></p>
									    	</a>
									    </li>
									    <li>
									    	<a class="item" href="#" data-field="koszty_administracyjne" data-value="<?= $data['koszty_administracyjne'] ?>" data-color="#A14AB2">
										    	<p class="_color" style="background-color: #A14AB2;"></p>
										    	<p class="_label">Koszty administracyjne</p>
										    	<p class="_value"><?= number_format_h($data['koszty_administracyjne']) ?></p>
									    	</a>
									    </li>
									    <li>
									    	<a class="item" href="#" data-field="koszty_finansowe" data-value="<?= $data['koszty_finansowe'] ?>" data-color="#297979">
										    	<p class="_color" style="background-color: #297979;"></p>
										    	<p class="_label">Koszty finansowe</p>
										    	<p class="_value"><?= number_format_h($data['koszty_finansowe']) ?></p>
									    	</a>
									    </li>
									    
								    </ul>
							    </div>
						    
					    </div>
				    </div>
					
				</section>
			</div>
			
			<div class="block">
				<header>Koszty kampanii 1% w <?= $sprawozdanie->getData('rocznik') ?> roku:</header>
				<section class="content">
					
					<div class="global_info text-center">
					    <p class="value"><?= implode(', ', $procent_parts) ?></p>
					</div>
					
				</section>
			</div>
			
			<? } ?>
			
			<? if( $czesci = $sprawozdanie->getLayer('czesci') ) { ?>
			<div class="block block-files">
				<header>Pliki:</header>
				<section class="content">
					
					<ul>
					<? foreach( $czesci as $c ) {?>
						
						<li class="col-md-4 documentFastCheck">
							<a data-id="<?= $c['id'] ?>" data-documentid="<?= $c['dokument_id'] ?>" href="<?= $object->getUrl() ?>/sprawozdania_opp/<?= $sprawozdanie->getId() ?>?c=<?= $c['id'] ?>" >
							<div class="avatar">
								<img src="http://docs.sejmometr.pl/thumb/1/<?= $c['dokument_id'] ?>.png" />
							</div><div class="content">
								<?= $c['nazwa'] ?>
							</div>
							</a>
						</li>
						
					<? } ?>
					</ul>
					
				</section>
			</div>
			<? } ?>
		
		</div>
	
	</div>
</div>



<?
echo $this->Element('dataobject/pageEnd');
