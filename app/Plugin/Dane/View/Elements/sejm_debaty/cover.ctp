<?
$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-sejmdebaty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.sejmdebaty');

$glosowania = array();
if( @$dataBrowser['aggs']['glosowania']['top']['hits']['hits'] )
	foreach( $dataBrowser['aggs']['glosowania']['top']['hits']['hits'] as $hit )
		$glosowania[ $hit['fields']['id'][0] ] = $hit;
?>

<div class="row">
<div class="col-md-9">

	<? if( @$dataBrowser['aggs']['wystapienia']['top']['hits']['hits'] ) {?>
	<ul class="debata-wystapienia" did="<?= $debata->getId() ?>"<? if( isset($wystapienie) ){?> wid="<?= $wystapienie->getId() ?>"<?}?>>
		<? foreach( $dataBrowser['aggs']['wystapienia']['top']['hits']['hits'] as $doc ) { ?>
		<li>
			<?
							
			echo $this->Dataobject->render($doc, 'sejm_debaty-wystapienie', array(
				'html' => (
					isset($wystapienie) && 
					( $wystapienie->getId()==$doc['fields']['id'][0] )
				) ? $wystapienie->getLayer('html') : false,
			));

			if( @$doc['fields']['source'][0]['data']['sejm_wystapienia.glosowanie_id'] ) {
				
				$glosowanie = $glosowania[ $doc['fields']['source'][0]['data']['sejm_wystapienia.glosowanie_id'] ];
				echo '<div class="glosowanie">' . $this->Dataobject->render($glosowanie, 'default') . '</div>';
				
			}
			?>
		</li>
		<? } ?>
	</ul>
	<? } ?>
        
</div><div class="col-md-3">
	
	

        
	
	
	<? if( @$dataBrowser['aggs']['punkty']['top']['hits']['hits'] ) { ?>
	<div class="stickybar">
		<div class="punkty">
			<p class="title">Rozpatrywane punkty porządku dziennego:</p>
			<ul>
			<? 
			foreach( $dataBrowser['aggs']['punkty']['top']['hits']['hits'] as $doc ) {
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