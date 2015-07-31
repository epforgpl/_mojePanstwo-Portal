<?
	$static = $object->getStatic();
?>
<div class="static">
	<div class="row">
	
	<? if( $object->getData('typ_id')=='1' ) { ?>
	
		<? if( isset($static['reprezentant']) && !empty($static['reprezentant']) ) { ?>
			<div class="col-md-6">
				<p>Przedstawiciel wnioskodawców:</p>
				<div class="mowca">
					<? if( $static['reprezentant']['avatar'] ) {?>
						<a class="link-discrete" href="/dane/poslowie/<?= $static['reprezentant']['id'] ?>"><img src="http://resources.sejmometr.pl/mowcy/a/3/<?= $static['reprezentant']['id'] ?>.jpg" /></a>
						<div class="mowca-content">
							<p><a class="link-discrete" href="/dane/poslowie/<?= $static['reprezentant']['id'] ?>"><?= $static['reprezentant']['nazwa'] ?></a></p>
						</div>
					<? } else { ?>
						<div>
							<p><a class="link-discrete" href="/dane/poslowie/<?= $static['reprezentant']['id'] ?>"><?= $static['reprezentant']['nazwa'] ?></a></p>
						</div>
					<? } ?>
				</div>
			</div>	
		<? } ?>
	
	<? } elseif( $object->getData('typ_id')=='7' ) { ?>
	
		<? if( isset($static['komisje']) && !empty($static['komisje']) ) { ?>
			<div class="col-md-6">
				<p>Autorzy sprawozdania:</p>
				<ul>
				<? foreach( $static['komisje'] as $k ) {?>
					<li><a class="link-discrete" href="/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/komisje/<?= $k['id'] ?>"><?= $k['nazwa'] ?></a></li>
				<? } ?>
				</ul>
			</div>	
		<? } ?>
		
		<? if( isset($static['sprawozdawca']) && !empty($static['sprawozdawca']) ) { ?>
			<div class="col-md-6">
				<p>Sprawozdawca komisji:</p>
				<div class="mowca">
					<? if( $static['sprawozdawca']['avatar'] ) {?>
						<a class="link-discrete" href="/dane/poslowie/<?= $static['sprawozdawca']['id'] ?>"><img src="http://resources.sejmometr.pl/mowcy/a/3/<?= $static['sprawozdawca']['id'] ?>.jpg" /></a>
						<div class="mowca-content">
							<p><a class="link-discrete" href="/dane/poslowie/<?= $static['sprawozdawca']['id'] ?>"><?= $static['sprawozdawca']['nazwa'] ?></a></p>
						</div>
					<? } else { ?>
						<div>
							<p><a class="link-discrete" href="/dane/poslowie/<?= $static['sprawozdawca']['id'] ?>"><?= $static['sprawozdawca']['nazwa'] ?></a></p>
						</div>
					<? } ?>
				</div>
			</div>	
		<? } ?>
	
	<? } ?>
	
	</div>
</div>