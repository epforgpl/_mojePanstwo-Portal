<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

echo $this->Html->css($this->Less->css('krs-cover', array('plugin' => 'Krs')));

$options = array(
    'mode' => 'init',
);
?>


<div class="col-xs-12">

        <div class="appBanner">
            <h1 class="appTitle">Krajowy Rejestr Sądowy</h1>
            <p class="appSubtitle">Przeglądaj informacje o organizacjach gospodarczych.</p>
            
            <div class="appSearch form-group">
				<div class="input-group">
					<input class="form-control" placeholder="Szukaj organizacji i osób..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
	                        <span class="glyphicon glyphicon-search"></span>
	                    </button>
					</span>
				</div>
			</div>            
        </div>
		
		<div class="row">
		
			<div class="col-xs-8">
				<div class="block">
			        <header>Formy prawne</header>
			
			        <section class="aggs-init">
			            
			        </section>
				</div>
		    </div>
			
			<? if( $dzialalnosci = $dataBrowser['aggs']['krs_podmioty']['dzialalnosci']['sekcja']['buckets'] ) { ?>
				<div class="col-xs-4">
					<div class="block">
				        <header>Przeglądaj według działalności:</header>
				
				        <section class="aggs-init">
				            <ul class="pkd-list">
				            <? foreach( $dzialalnosci as $d ) { ?>
				            	<li class="pkd-item">
				            		<a href="/krs/pkd/<?= $d['key'] ?>">
					            		<img class="pkd-icon" src="/krs/icons/pkd/sekcje/<?= $d['key'] ?>.svg" />
					            		<p class="pkd-title normalizeText"><?= $this->Text->truncate($d['nazwa']['buckets'][0]['key'], 35) ?></p>
				            		</a>
				            	</li>
				            <? } ?>
				            </ul>
				        </section>
					</div>
			    </div>
			<? } ?>
		
		</div>
		
	    <div class="block col-xs-12">
	        <header>Formy prawne organizacji</header>
	
	        <section class="aggs-init">
	            <div class="dataAggs">
	                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
	                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.forma_prawna_id]="
	                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['typ_id'])) ?>">
	                    <div class="chart">
	                    </div>
	                </div>
	            </div>
	        </section>
	    </div>
	
	    <div class="block col-xs-12">
	        <header>Kapitalizacja spółek handlowych</header>
	
	        <section class="aggs-init">
	            <div class="dataAggs">
	                <div class="agg agg-ColumnsVertical"
	                     data-choose-request="dane/krs_podmioty?conditions[krs_podmioty.wartosc_kapital_zakladowy]="
	                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['kapitalizacja'])) ?>">
	                    <div class="chart"></div>
	                </div>
	            </div>
	        </section>
	    </div>
	
	    <div class="block col-xs-12">
	        <header>Rejestracje nowych organizacji w czasie</header>
	
	        <section class="aggs-init">
	            <div class="dataAggs">
	                <div class="agg agg-DateHistogram"
	                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['date'])) ?>">
	
	                    <div class="chart"></div>
	                </div>
	            </div>
	        </section>
	    </div>
	    	
</div>
