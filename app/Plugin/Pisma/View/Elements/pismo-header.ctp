<div class="row">
<div class="col-md-12 pismoTitle">
    
    <h1><?= $pismo['nazwa'] ?></h1>
	
    <? if( isset($alert) && $alert && !AuthComponent::user('id') ) { ?>
    	<div class="alert alert-dismissable alert-warning">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<h4>Uwaga!</h4>
			<p>Nie jesteś zalogowany. Twoje pismo będzie przechowywane na tym komputerze przez 24 godziny. <a href="/login">Zaloguj się</a>, aby trwale zapisać to pismo na swoim koncie.</p>
		</div>
    <? } ?>
	
	<? if( $pismo['from_user_type']=='account' ) {?>
    <div class="letter-meta">
		Autor: <?= $pismo['from_user_name'] ?>
    </div>
    <? } ?>
    
</div>
</div>