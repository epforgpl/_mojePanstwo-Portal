<?

$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));

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

<div class="row">
	<div class="col-md-9">
		
		<? echo $this->Element('Dane.DataBrowser/browser'); ?>

	</div>
	<div class="col-md-3">        
	
	
		<? if( @$dataBrowser['aggs']['all']['punkty']['top']['hits']['hits'] ) { ?>
		<div class="stickybar">
			<div class="punkty">
				<p class="title">Rozpatrywane punkty porządku dziennego:</p>
				<ul>
				<? 
				foreach( $dataBrowser['aggs']['all']['punkty']['top']['hits']['hits'] as $doc ) {
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