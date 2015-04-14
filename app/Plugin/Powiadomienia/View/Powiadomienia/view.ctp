<?php $this->Combinator->add_libs('css', $this->Less->css('powiadomienia-base', array('plugin' => 'Powiadomienia'))); ?>

<style>
	.dataBrowser .dataCounter {
		display: none;
	}
	#_main .alerts-login {
		margin: 20px 0 0;
	}
</style>

<?= $this->Element('appheader'); ?>



<? 
	if( $dataBrowser['hits'] ) {
?>

<? if( !$this->Session->read('Auth.User.id') ) { ?>
<div class="container">
	<div class="alert alerts-login alert-dismissable alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<h4>Uwaga!</h4>
		<p>Nie jesteś zalogowany. Twoje subskrypcje będą przetwarzane i przechowywane na tym urządzeniu przez 24 godziny. <a class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale zapisać subskrypcje na swoim koncie.</p>
	</div>
</div>
<? } ?>

<div class="objectsPage">
	<?
		$options = array(
			'title' => 'Dane, które obserwujesz:',
		);
		if( isset($title) )
			$options['title'] = $title;
			
		echo $this->Element('Dane.DataBrowser/browser', $options);
	?>
</div>
<? } else { ?>

<div class="container">
	<div class="informationBlock missing col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
        <div class="col-xs-12 information">

            <h2>Nie obserwujesz jeszcze żadnych danych</h2>

            <h3>Dowiedz się jak skonfigurować subskrypcje i otrzymywać powiadomienia o interesujących Cię danych publicznych.</h3>
            <a target="_self" href="/powiadomienia/jak_to_dziala" class="btn btn-info">Jak to działa?</a>
        </div>
    </div>
</div>

<? } ?>