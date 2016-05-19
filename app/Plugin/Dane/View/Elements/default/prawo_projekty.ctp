<? if( $kluby = $object->getData('kluby') ) { ?>		
<ul class="prawo_projekty-autorzy row">
<? foreach( $kluby as $klub ) { $href = "/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/kluby/" . $klub['id']; ?>
	<li class="col-sm-6">
		<a href="<?= $href ?>"><img class="pull-left margin-right-10" src="http://resources.sejmometr.pl/s_kluby/<?= $klub['id'] ?>_a_t.png" /></a>
		<a href="<?= $href ?>"><?= $klub['nazwa'] ?></a>
	</li>
<? } ?>
</ul>
<? } ?>