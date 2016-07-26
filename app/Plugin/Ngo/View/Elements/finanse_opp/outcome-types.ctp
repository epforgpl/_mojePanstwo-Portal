<div class="container">
	<div class="charts row">
	    <div id="chart-outcome-types" class="col-md-8 col-md-offset-2">
		    
		    <h2>Koszty według typów:</h2>
		    
		    <div class="chart"></div>
		    <div class="chart_description">
			    <ul>
				    <li>
				    	<a class="item" href="#" data-field="koszty_dzialalnosc_nieodplatna_pozytku_publicznego" data-value="<?= $aggs['suma.koszty_dzialalnosc_nieodplatna_pozytku_publicznego']['value'] ?>" data-color="#C42419">
					    	<p class="_color" style="background-color: #C42419;"></p>
					    	<p class="_label">Koszty prowadzenia nieodpłatnej działalności pożytku publicznego</p>
					    	<p class="_value"><?= number_format_h($aggs['suma.koszty_dzialalnosc_nieodplatna_pozytku_publicznego']['value']) ?></p>
				    	</a>
				    	<ul>
					    	<li>
						    	<a class="item" href="#" data-field="koszty_dzialalnosc_nieodplatna_pozytku_publicznego_procent" data-value="<?= $aggs['suma.koszty_dzialalnosc_nieodplatna_pozytku_publicznego_procent']['value'] ?>">
							    	<p class="_color"></p>
							    	<p class="_label">W tym finansowane z 1% podatku dochodowego od osób fizycznych</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.koszty_dzialalnosc_nieodplatna_pozytku_publicznego_procent']['value']) ?></p>
						    	</a>
						    </li>
				    	</ul>
				    </li>
				    <li>
				    	<a class="item" href="#" data-field="koszty_dzialalnosc_odplatna_pozytku_publicznego" data-value="<?= $aggs['suma.koszty_dzialalnosc_odplatna_pozytku_publicznego']['value'] ?>" data-color="#2D8E49">
					    	<p class="_color" style="background-color: #2D8E49;"></p>
					    	<p class="_label">Koszty prowadzenia odpłatnej działalności pożytku publicznego</p>
					    	<p class="_value"><?= number_format_h($aggs['suma.koszty_dzialalnosc_odplatna_pozytku_publicznego']['value']) ?></p>
				    	</a>
				    	<ul>
					    	<li>
						    	<a class="item" href="#" data-field="koszty_dzialalnosc_odplatna_pozytku_publicznego_procent" data-value="<?= $aggs['suma.koszty_dzialalnosc_odplatna_pozytku_publicznego_procent']['value'] ?>">
							    	<p class="_color"></p>
							    	<p class="_label">W tym finansowane z 1% podatku dochodowego od osób fizycznych</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.koszty_dzialalnosc_odplatna_pozytku_publicznego_procent']['value']) ?></p>
						    	</a>
						    </li>
				    	</ul>
				    </li>
				    <li>
				    	<a class="item" href="#" data-field="koszty_pozostale_ogolem" data-value="<?= $aggs['suma.koszty_pozostale_ogolem']['value'] ?>" data-color="#3E55B2">
					    	<p class="_color" style="background-color: #3E55B2;"></p>
					    	<p class="_label">Pozostałe koszty ogółem</p>
					    	<p class="_value"><?= number_format_h($aggs['suma.koszty_pozostale_ogolem']['value']) ?></p>
				    	</a>
				    	<ul>		    
						    <li>
						    	<a class="item" href="#" data-field="koszty_pozostale_ogolem_procent" data-value="<?= $aggs['suma.koszty_pozostale_ogolem_procent']['value'] ?>">
							    	<p class="_color"></p>
							    	<p class="_label">W tym finansowane z 1% podatku dochodowego od osób fizycznych</p>
							    	<p class="_value"><?= number_format_h($aggs['suma.koszty_pozostale_ogolem_procent']['value']) ?></p>
						    	</a>
						    </li>
					    </ul>
				    </li>
				    <li>
				    	<a class="item" href="#" data-field="koszty_dzialalnosc_gospodarcza" data-value="<?= $aggs['suma.koszty_dzialalnosc_gospodarcza']['value'] ?>" data-color="#E0AF4E">
					    	<p class="_color" style="background-color: #E0AF4E;"></p>
					    	<p class="_label">Koszty prowadzenia działalności gospodarczej</p>
					    	<p class="_value"><?= number_format_h($aggs['suma.koszty_dzialalnosc_gospodarcza']['value']) ?></p>
				    	</a>
				    </li>
				    <li>
				    	<a class="item" href="#" data-field="koszty_administracyjne" data-value="<?= $aggs['suma.koszty_administracyjne']['value'] ?>" data-color="#A14AB2">
					    	<p class="_color" style="background-color: #A14AB2;"></p>
					    	<p class="_label">Koszty administracyjne</p>
					    	<p class="_value"><?= number_format_h($aggs['suma.koszty_administracyjne']['value']) ?></p>
				    	</a>
				    </li>
				    <li>
				    	<a class="item" href="#" data-field="koszty_finansowe" data-value="<?= $aggs['suma.koszty_finansowe']['value'] ?>" data-color="#297979">
					    	<p class="_color" style="background-color: #297979;"></p>
					    	<p class="_label">Koszty finansowe</p>
					    	<p class="_value"><?= number_format_h($aggs['suma.koszty_finansowe']['value']) ?></p>
				    	</a>
				    </li>
				    
			    </ul>
		    </div>
		    
	    </div>
	</div>
</div>