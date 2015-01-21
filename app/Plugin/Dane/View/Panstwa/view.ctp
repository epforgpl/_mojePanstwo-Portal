<?
// $this->Combinator->add_libs('css', $this->Less->css('view-administracjapubliczna', array('plugin' => 'Dane')));
// $this->Combinator->add_libs('js', 'Dane.view-administracjapubliczna');
?>
<? echo $this->Element('dataobject/pageBegin'); ?>

    <div class="Panstwo">
		
		<? debug( $object->getLayer('stats') ) ?>
	
		<div class="row">
	        <div class="col-lg-12">
		        
		        <h2>Wykres highCharts pokazujący import/eksport z danym państwem w czasie.</h2>
		        <p>http://www.highcharts.com/demo/line-basic</p>
		        
	        </div>
		</div>
		
		<div class="row">
	        <div class="col-lg-12">
		        
		        <p class="text-center">Wybór rocznika</p>
		        
	        </div>
		</div>
		
		<div class="row">
	        <div class="col-lg-6">
		        
		        <h2 class="text-center">Import</h2>
		        
		        <p>Lista towarów o największej wartości importu w danym roku</p>
		        
	        </div>
	        <div class="col-lg-6">
		        
		        <h2 class="text-center">Eksport</h2>

		        <p>Lista towarów o największej wartości eksportu w danym roku</p>

		        
	        </div>
		</div>

    </div>

<?= $this->Element('dataobject/pageEnd'); ?>