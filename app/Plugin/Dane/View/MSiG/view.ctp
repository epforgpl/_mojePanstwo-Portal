<?
$this->Combinator->add_libs('css', $this->Less->css('view-msig', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>

<? if( $ogloszenia = @$object_aggs['ogloszenia']['dzialy']['buckets'] ) {?>
<ul class="dzialy">
	<? foreach( $ogloszenia as $dzial ) {?>
	<li>
		<h2><?= $dzial['nazwa']['buckets'][0]['key'] ?></h2>
		
		<? if( $pozycje = $dzial['top']['hits']['hits'] ) {?>
		<ul>
			<? foreach( $pozycje as $p ) {?>
			<li>
				<?= $this->Dataobject->render($p, 'default') ?>
			</li>
			<? } ?>
		</ul>
		<? } ?>
		
	</li>
	<? } ?>
</ul>
<? } ?>

<?= $this->Element('dataobject/pageEnd'); ?>