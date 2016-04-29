<?
$this->Combinator->add_libs('css', $this->Less->css('sejm-posiedzenie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-sejmdebaty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.sejmdebaty');

$glosowania = array();
if( @$dataBrowser['aggs']['glosowania']['top']['hits']['hits'] )
	foreach( $dataBrowser['aggs']['glosowania']['top']['hits']['hits'] as $hit )
		$glosowania[ $hit['fields']['id'][0] ] = $hit;

?>

<div class="row margin-top-10">
<div class="col-md-9">
	
	<?= $this->element('Dane.sejm_debaty/neighboors', array('neighboors' => $debata->getLayer('neighboors'))); ?>
	
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
			
			if(
				@$doc['_source']['data']['sejm_wystapienia']['glosowanie_id'] && 
				( $glosowanie = @$glosowania[ $doc['_source']['data']['sejm_wystapienia']['glosowanie_id'] ] )
			) {
				echo '<div class="glosowanie">' . $this->Dataobject->render($glosowanie, 'default') . '</div>';
			}
			?>
		</li>
		<? } ?>
	</ul>
	<? } ?>
     
	<?= $this->element('Dane.sejm_debaty/neighboors', array('neighboors' => $debata->getLayer('neighboors'))); ?>
    
</div><div class="col-md-3">
	
	
	
	
	<? if( @$dataBrowser['aggs']['punkty']['top']['hits']['hits'] ) { ?>
	<div class="stickybar">
		<div class="block nobg block-simple">
			<header>Punkty porządku dziennego:</header>
			<section class="content nopadding">
				<div class="punkty">
					<ul>
					<? 
					foreach( $dataBrowser['aggs']['punkty']['top']['hits']['hits'] as $doc ) { 
						$data = $doc['_source']['data'];
					?>
						<li class="nopadding">
							<p><a href="/dane/instytucje/3214,sejm/punkty/<?= $data['sejm_posiedzenia_punkty']['id']?>"><span class="badge"><?= $data['sejm_posiedzenia_punkty']['numer']?></span> <?= smarty_modifier_truncate($data['sejm_posiedzenia_punkty']['tytul'], 135, ' (...) ', false, true) ?></a></p>
						</li>
					<? } ?>
					</ul>
				</div>
			</section>
		</div>
	</div>
	<? } ?>
	
</div>
</div>