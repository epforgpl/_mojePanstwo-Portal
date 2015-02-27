<?
	$this->Combinator->add_libs('js', 'Pisma.pisma-button');
	$this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
?>

<ul class="object-actions-ul">
<? foreach( $buttons as $key => $data ) {
	if( $key=='pisma' ) {?>

	<li>
		<p class="btn_cont">
			<button class="btn btn-success pisma-list-button" data-adresatid="<?= $data['adresat_id'] ?>">Wyślij pismo...</button>
		</p>
		<p class="desc">
			Kliknij, aby wysłać pismo do <?= $name ?>.
		</p>
	</li>

	<? }
} ?>	
</ul>



<? /*
	<li>
		<p class="btn_cont">
			<button class="btn btn-success">Obserwuj...</button>
		</p>
		<p class="desc">
			Kliknij, aby otrzymywać powiadomienia o pracy tej instytucji
		</p>
	</li>
*/ ?>