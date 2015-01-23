<div class="col-md-12 pismoTitle">
    <h1><?= $pismo['nazwa'] ?></h1>
	
	<? if( ($pismo['from_user_type']=='anonymous') || ($pismo['from_user_type']=='account') ) {?>
    <div class="letter-meta">
    <?
		if( $pismo['from_user_type']=='anonymous' ) {    
	?>
		<p>Nie jesteś zalogowany. Twoje pismo będzie przechowywane przez 24 godziny. <a href="#">Zaloguj się</a>, aby zapisać to pismo na trwałe.</p>
	<? } elseif( $pismo['from_user_type']=='account' ) { ?>
		User
	<? } ?>
    </div>
    <? } ?>
    
</div>