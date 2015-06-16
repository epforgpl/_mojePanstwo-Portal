<? if (!$this->Session->read('Auth.User.id')) { ?>
    <div class="container">
        <div class="alert alerts-login alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Uwaga!</h4>

            <p>Nie jesteś zalogowany. Twoje subskrypcje będą przetwarzane i przechowywane na tym urządzeniu przez 24
                godziny. <a class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale zapisać
                subskrypcje na swoim koncie.</p>
        </div>
    </div>
<? } ?>

<? /*
<div class="objectsPage">
	<?
		$options = array(
			'title' => 'Powiadomienia o nowych danych',
		);
		if( isset($title) )
			$options['title'] = $title;
			
		echo $this->Element('Dane.DataBrowser/browser', $options);
	?>
</div>
*/ ?>