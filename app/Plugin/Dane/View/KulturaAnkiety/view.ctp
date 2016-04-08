<?
	$this->Combinator->add_libs('css', $this->Less->css('view-kultura_ankiety', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'Dane.view-kultura_ankiety');
?>

<?php echo $this->Element('dataobject/pageBegin'); ?>
<div class="object margin-top--20">
    
    <?
	    if( 
	    	( $captions = $object->getStatic('captions') ) && 
	    	( $data = $object->getLayer('data') )
    	) {
    ?>
	    
	    
	    <? $filter_data = $data['']; ?>
	    <div class="block block-captions">
		    <header>Ogółem</header>
			<section class="content">
				<ul class="captions">
					
					<? 
						foreach( $captions as $c ) {
							if( isset($filter_data[ $c['id'] ]) ) {
					?>
						<li data-caption_id="<?= $c['id'] ?>">
							<div class="row">
								<div class="col-md-4">
									<p class="_label"><?= $c['title'] ? $c['title'] : "&nbsp;" ?></p>
								</div><div class="col-md-8">
									<p class="value" style="width: <?= round($filter_data[ $c['id'] ]) ?>%;"><?= round($filter_data[ $c['id'] ], 1) ?>%</p>
								</div>
							</div>
						</li>
					<? 
							}
						}
					?>
					
				</ul>
			</section>
		</div>
		
		
		
	
		
		
		<ul class="nav nav-tabs">
			<li class="active"><a aria-expanded="true" href="#sex" data-toggle="tab">Według płci</a></li>
			<li class=""><a aria-expanded="false" href="#age" data-toggle="tab">Według wieku</a></li>		  
			<li class=""><a aria-expanded="false" href="#education" data-toggle="tab">Według wykształcenia</a></li>		  
			<li class=""><a aria-expanded="false" href="#region" data-toggle="tab">Według regionu</a></li>		  
			<li class=""><a aria-expanded="false" href="#city_size" data-toggle="tab">Według wielkości miejscowości</a></li>	  
			<li class=""><a aria-expanded="false" href="#household" data-toggle="tab">Według typu gospodarstwa</a></li>		  
		</ul>
						
		<div class="tab-content">
		
			<?= $this->element('Dane.kultura_ankiety/chart', array(
				'title' => 'Według płci',
				'captions' => $captions,
				'data' => $data,
				'param' => 'sex',
				'columns' => array(
					'M' => 'Mężczyźni',
					'W' => 'Kobiety',
				),
				'active' => true,
			)); ?>
			
			<?= $this->element('Dane.kultura_ankiety/chart', array(
				'title' => 'Według wieku',
				'captions' => $captions,
				'data' => $data,
				'param' => 'age',
				'columns' => array('15 – 24 lat', '25 – 34 lata', '35 – 49 lat', '50 – 64 lata', '65 lat i więcej'),
			)); ?>
			
			<?= $this->element('Dane.kultura_ankiety/chart', array(
				'title' => 'Według wykształcenia',
				'captions' => $captions,
				'data' => $data,
				'param' => 'education',
				'columns' => array('Wyższe', 'Średnie', 'Zasadnicze zawodowe', 'Pozostałe'),
			)); ?>
			
			<?= $this->element('Dane.kultura_ankiety/chart', array(
				'title' => 'Według regionu',
				'captions' => $captions,
				'data' => $data,
				'param' => 'region',
				'columns' => array('Centralny', 'Południowy', 'Wschodni', 'Północno-zachodni', 'Południowo-zachodni', 'Północny'),
			)); ?>
			
			<?= $this->element('Dane.kultura_ankiety/chart', array(
				'title' => 'Według wielkości miejscowości',
				'captions' => $captions,
				'data' => $data,
				'param' => 'city_size',
				'columns' => array('Miasta – razem', 'Miasta o liczbie mieszkańców 500 tys. i więcej', 'Miasta o liczbie mieszkańców 200-499 tys.', 'Miasta o liczbie mieszkańców 100-199 tys.', 'Miasta o liczbie mieszkańców 20-99 tys.', 'Miasta o liczbie mieszkańców poniżej 20 tys.', 'Wsie'),
			)); ?>
			
			<?= $this->element('Dane.kultura_ankiety/chart', array(
				'title' => 'Według typu gospodarstwa',
				'captions' => $captions,
				'data' => $data,
				'param' => 'household',
				'columns' => array('Gospodarstwa pracowników', 'Gospodarstwa robotnicze', 'Gospodarstwa nierobotnicze', 'Gospodarstwa rolników', 'Gospodarstwa pracujących na własny rachunek', 'Gospodarstwa emerytów i rencistów', 'Gospodarstwa emerytów', 'Gospodarstwa rencistów'),
			)); ?>
		
		</div>
		
	<? } ?>
    
</div>
<?php echo $this->Element('dataobject/pageEnd'); ?>
