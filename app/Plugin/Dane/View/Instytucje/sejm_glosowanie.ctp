<?

$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('sejm-glosowanie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.sejm-glosowanie');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $glosowanie,
    'objectOptions' => array(
	    'truncate' => 1000,
	),
));
?>


<div class="row margin-top-10">
	<div class="col-md-6">
	<? if( $glosy = @$glosowanie_aggs['glosy']['glosy']['hits']['hits'] ) { ?>
	
		<div class="block">
			<header>Wyniki indywidualne</header>
			<section class="content nopadding">
				<ul class="wyniki_indywidualne">
				<? foreach( $glosy as $g ) { $g = $g['_source']; ?>
					<li>
						
						<div class="img_content">
							
							<img src="http://resources.sejmometr.pl/mowcy/a/2/<?= $g['mowca_id'] ?>.jpg" />
							
						</div><div class="g_content">
							
							<p class="title">
								<a><?= $g['posel_nazwa'] ?></a>
							</p>
							
							<p class="desc">
								<?= $g['klub_skrot'] ?>
							</p>
							
						</div><div class="glos">
							
						<? if( $g['glos_id']=='1' ) { ?>
							<span class="label label-success">Za</span>
						<? } elseif( $g['glos_id']=='2' ) { ?> 
							<span class="label label-danger">Przeciw</span>							
						<? } elseif( $g['glos_id']=='3' ) { ?> 
							<span class="label label-primary">Wstrzymanie</span>
						<? } elseif( $g['glos_id']=='4' ) { ?> 
							<span class="label label-default">Nieobecność</span>							
						<? } ?>
							
						</div>
					
					</li>
				<? } ?>
				</ul>
			</section>
		</div>
		
	<? } ?>
	</div>
	<div class="col-md-6">        
			
		<? if( @$glosowanie_aggs['all']['punkty']['top']['hits']['hits'] ) { ?>
		<div class="stickybar">
			<div class="punkty">
				<p class="title">Rozpatrywane punkty porządku dziennego:</p>
				<ul>
				<? 
				foreach( $glosowanie_aggs['all']['punkty']['top']['hits']['hits'] as $doc ) {
					$data = $doc['fields']['source'][0]['data'];
				?>
					<li>
						<p><a href="/dane/instytucje/3214,sejm/punkty/<?= $data['sejm_posiedzenia_punkty.id']?>"><span class="badge">#<?= $data['sejm_posiedzenia_punkty.numer']?></span> <?= smarty_modifier_truncate($data['sejm_posiedzenia_punkty.tytul'], 135, ' (...) ', false, true) ?></a></p>
					</li>
				<? } ?>
				</ul>
			</div>
		</div>
		<? } ?>
	
	</div>
</div>


<? echo $this->Element('dataobject/pageEnd'); ?>