<?
	// $this->Combinator->add_libs('css', $this->Less->css('view-prawo_projekty', array('plugin' => 'Dane')));
?>

<div class="margin-top-20">
	
	<? if( $kluby = $projekt->getData('kluby') ) { ?>
	<div class="block">
		<header>Kluby, których posłowie podpisali się pod projektem:</header>
		<section class="content">
			<ul class="prawo_projekty_items">
			<? foreach( $kluby as $klub ) { $href = "/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/kluby/" . $klub['id']; ?>
				<li>
					<a href="<?= $href ?>"><img class="pull-left margin-right-10" src="http://resources.sejmometr.pl/s_kluby/<?= $klub['id'] ?>_s_t.png" /></a>
					<a href="<?= $href ?>"><?= $klub['nazwa'] ?></a>
				</li>
			<? } ?>
			</ul>
		</section>
	</div>
	<? } ?>
	
	<? if( $poslowie = $projekt_poslowie ) { ?>
	<div class="block">
		<header>Posłowie, którzy podpisali się pod projektem:</header>
		<section class="content">
			<ul class="prawo_projekty_items fixed_height">
			<? foreach( $poslowie as $p ) { $href = '/dane/poslowie/' . $p['_source']['data']['poslowie']['id'] . ',' . $p['_source']['slug']; ?>
				<li class="posel">
					<a href="<?= $href ?>"><img class="pull-left margin-right-10" src="http://resources.sejmometr.pl/mowcy/a/2/<?= $p['_source']['data']['ludzie']['id'] ?>.jpg" /></a>
					<a href="<?= $href ?>"><?= $p['_source']['data']['poslowie']['nazwa'] ?></a>
				</li>
			<? } ?>
			</ul>
		</section>
	</div>
	<? } ?>
	
</div>


<div class="margin-top-30">
	<p class="_src text-left"><a href="http://sejm.gov.pl/Sejm8.nsf/PrzebiegProc.xsp?nr=<?= $projekt->getData('druk_nr') ?>" target="_blank"><span class="glyphicon glyphicon-link"></span> Źródło (Sejm)</a></p>
</div>