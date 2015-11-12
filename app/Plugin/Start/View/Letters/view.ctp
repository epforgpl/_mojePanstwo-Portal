<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start'))); ?>
<?php

// dropzone
$this->Html->css(array('dropzone'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Combinator->add_libs('js', 'dropzone.js') ;

// datepicker
$this->Html->css(array('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Html->script(array('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', '../plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pl.min'), array('inline' => 'false', 'block' => 'scriptBlock'));

$accessDict = array(
	'prywatne',
	'publiczne'
);

?>
<?php $this->Combinator->add_libs('js', 'Start.pismo.js') ?>
<?php // $this->Combinator->add_libs('js', 'Start.letters-social-share.js') ?>

<?php echo $this->Html->script('/Start/js/zeroclipboard', array('block' => 'scriptBlock')); ?>

<? $href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>

<?= $this->element('Start.pageBegin'); ?>


<header class="collection-header">

	<ul class="breadcrumb">
	  <li><a href="/moje-pisma">Moje Pisma</a></li>
	  <li class="active">Pismo</li>
	</ul>

	<div class="overflow-auto">

		<div class="content pull-left">
			<i class="object-icon icon-applications-pisma"></i>
			<div class="object-icon-side">
				<h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
					<? /*<a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">*/ ?>
						<?= $pismo['nazwa'] ?>
					<? /*</a>*/ ?>
				</h1>
			</div>
		</div>


		<ul class="buttons pull-right">
			<li>
				<input type="hidden" name="delete"/>
				<button
					data-tooltip="true"
					data-original-title="Widoczność pisma"
					data-placement="bottom"
					class="btn btn-default btnRemove btn"
					data-toggle="modal"
					data-target="#accessOptions">
					<i class="glyphicon glyphicon-share" title="Ustawienia widoczności pisma" aria-hidden="true"></i>
				</button>
			</li>
			<li>
				<form action="" method="post">
					<input type="hidden" name="delete"/>
					<button
						data-tooltip="true"
						data-original-title="Usuń pismo"
						data-placement="bottom"
						class="btn btn-default btnRemove btn"
						type="submit">
						<i class="glyphicon glyphicon-trash" title="Usuń pismo" aria-hidden="true"></i>
					</button>
				</form>
			</li>

		</ul>

	</div>
</header>

<div class="modal fade" id="accessOptions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="well bs-component mp-form margin-top-0 margin-bottom-0">
				<div class="modal-body padding-bottom-0 margin-bottom-0">
					<form action="" class="form-horizontal" method="post">
						<fieldset>
							<div class="form-group">
								<div class="col-lg-12">
									<? foreach($accessDict as $value => $label) { ?>
										<div class="radio">
											<input
												id="access<?= $value ?>"
												type="radio"
												name="is_public"
												value="<?= $value ?>"
												<?= ((int) $pismo['is_public'] == $value) ? 'checked' : '' ?>>
											<label for="access<?= $value ?>">
												<?= ucfirst($label) ?>
											</label>
										</div>
									<? } ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-9">
									<button type="reset" data-dismiss="modal" class="btn btn-default">Anuluj</button>
									<button type="submit" name="save" class="btn btn-md btn-primary btn-icon"><i class="icon glyphicon glyphicon-pencil"></i>Zapisz
									</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<ul class="collection-meta">
	<li>Pismo prywatne</li>
</ul>



<? /*
	
	<div class="letter-meta">
        <p>Autor:
            <b><? echo ($pismo['from_user_type'] == 'account') ? $pismo['from_user_name'] : "Anonimowy użytkownik" ?></b>
        </p>
        <? if ($pismo['sent']) { ?>
            <p class="small"><b>pismo zostałe wysłane do
                    adresata <?= $this->Czas->dataSlownie($pismo['sent_at']) ?></b></p>
        <? } else { ?>
            <p class="small"><b>Przed wysłaniem pisma należy je zapisać</b></p>
        <? } ?>
    </div>
         
         
         
    <div class="editor-tooltip">
	    
	
	    <? if ($pismo['is_owner']) {
	        if (!$this->Session->read('Auth.User.id')) { ?>
	            <div class="alert alert-dismissable alert-success">
	                <button type="button" class="close" data-dismiss="alert">×</button>
	                <h4>Uwaga!</h4>
	
	                <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24
	                    godziny. <a
	                        class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale
	                    przechowywać pisma na
	                    swoim koncie.</p>
	            </div>
	        <? } ?>
	        <ul class="form-buttons">
	            <? if ($pismo['access'] == 'private') { ?>
	                <li class="inner-addon col-xs-12">
	                    <form action="" method="post">
	                        <input type="hidden" name="access" value="public">
	
	                        <p><b>pismo jest prywatne.</b> Tylko Ty masz do niego dostęp.
	                            <button class="clean" type="submit">Kliknij, aby udostępnić pismo
	                                publicznie.
	                            </button>
	                        </p>
	                    </form>
	                </li>
	            <? } elseif ($pismo['access'] == 'public') { ?>
	                <li class="inner-addon col-xs-12">
	                    <form action="" method="post">
	                        <input type="hidden" name="access" value="private">
	
	                        <p>
	                            <b>pismo jest publiczne.</b>
	                            <button class="clean" type="submit">Kliknij, aby zmienić jego widoczność
	                                na prywatną.
	                            </button>
	                        </p>
	                    </form>
	                </li>
	                <li class="inner-addon col-xs-12 col-sm-6 col-md-4">
	                    <div class="form-group clipboard">
	                        <label for="clipboardCopy">Link do dokumentu</label>
	
	                        <div class="input-group">
	                            <input id="clipboardCopy" type="text" class="form-control"
	                                   readonly="readonly"
	                                   value="<?php echo Router::url($this->here, true); ?>"/>
	                            <span class="input-group-btn">
	                                <button id="clipboardCopyBtn"
	                                        class="btn btn-default glyphicon glyphicon-copy"
	                                        data-clipboard-text="<?php echo Router::url($this->here, true); ?>"
	                                        type="button"></button>
	                            </span>
	                        </div>
	                    </div>
	                </li>
	                <li class="inner-addon col-xs-12 col-sm-6 col-md-4 shareIt">
	                    <span><strong>Udostępnij</strong></span>
	
	                    <div id="fb-root"></div>
	                    <a class="btn btn-social-icon btn-facebook"
	                       href="http://www.facebook.com/sharer.php?u=<?php echo Router::url($this->here, true); ?>"
	                       target="_blank">
	                        <i class="fa fa-facebook"></i>
	                    </a>
	                    <a class="btn btn-social-icon btn-twitter" href="https://twitter.com/share"
	                       target="_blank"
	                       data-url="<?php echo Router::url($this->here, true); ?>"
	                       data-lang="<?php if (Configure::read('Config.language') == 'pol') {
	                           echo('pl');
	                       } else {
	                           echo('en');
	                       } ?>">
	                        <i class="fa fa-twitter"></i>
	                    </a>
	                    <a class="btn btn-social-icon btn-wykop"
	                       href="http://www.wykop.pl/dodaj/link/?url=<?php echo Router::url($this->here, true); ?>&title=<?= $pismo['nazwa'] ?>"
	                       target="_blank">
	                        <img class="fa" src="/Start/img/wykop_logo.png" alt="wykop.pl"
	                             onerror="imgFixer(this)"/>
	                    </a>
	                </li>
	            <? } ?>
	        </ul>
	    <? } ?>
	</div>
	<ul class="buttons pull-right col-xs-12">
	    <li class="inner-addon">
	        <form onsubmit="return confirm('Czy na pewno chcesz usunąć pismo?');"
	              method="post"
	              action="/moje-pisma/<?= $pismo['alphaid'] ?>,<?= $pismo['slug'] ?>">
	            <button name="delete" type="submit" class="btn btn-icon btn-danger"><i
	                    class="icon glyphicon glyphicon-trash"></i>Skasuj
	            </button>
	        </form>
	    </li>
	    <? if (!$pismo['sent']) { ?>
	        <li class="inner-addon">
	            <a href="<?= $href_base . '/edit' ?>" target="_self"
	               class="btn btn-default btn-icon"><i
	                    class="icon glyphicon glyphicon-edit"></i>Edytuj</a>
	        </li>
	    <? } ?>
	    <? if ($pismo['to_email']) { ?>
	        <li class="inner-addon">
	            <? if (!$pismo['sent']) { ?>
	                <a title="Możesz wysłać pismo do adresata poprzez e-mail"
	                   href="#" target="_self"
	                   class="btn btn-primary sendPismo btn-icon"><i
	                        class="icon glyphicon glyphicon-send"></i>Wyślij...</a>
	            <? } ?>
	        </li>
	    <? } ?>
	</ul>     
         
         
         
         
                        
*/ ?>


<div class="letter-table">
	<div class="row">
		<div class="col-sm-2">
			<p class="_label">Od:</p>
		</div><div class="col-sm-10">
			<p><?= $pismo['from_user_name'] ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<p class="_label">Do:</p>
		</div><div class="col-sm-10">
			<p><?= $pismo['to_name'] ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<p class="_label">Temat:</p>
		</div><div class="col-sm-10">
			<p><?= $pismo['tytul'] ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="text">
				<?= $pismo['content'] ?>
			</div>
		</div>
	</div>
	<? if( $pismo['sent'] ) {?>
	<div class="row sent">
		<div class="col-sm-12">
			<p>Wysłane <?= dataSlownie($pismo['sent_at']) ?>.</p>
		</div>
	</div>
	<? } ?>
</div>


<? if( !$pismo['sent'] ) { ?>

<div id="sendPismoModal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Wysyłanie pisma</h4>
            </div>
            <form action="<?= $href_base ?>" method="POST">
                <div class="modal-body">

                    <? if ($this->Session->read('Auth.User.id')) { ?>

                        <p class="text-center">Twoje pismo zostanie wysłane z adresu <span
                                class="email">pisma@mojepanstwo.pl</span> na
                            adres:</p>

                        <p class="email email-big text-center"><?= $pismo['to_email'] ?></p>

                        <div class="additional-desc">
                            <p>W polu <b>CC</b> wiadomości zostanie podany Twój
                                adres e-mail - otrzymasz więc kopię wysłanego
                                pisma.
                            </p>

                            <p>W polu <b>Reply-to</b> wiadomości również
                                zostanie podany Twój adres email, aby adresat
                                przesłał odpowiedź bezpośrednio na Twój adres.
                            </p>
                        </div>

                    <? } else { ?>

                        <p>Twoje pismo zostanie wysłane z adresu <span
                                class="email">pisma@mojepanstwo.pl</span> na
                            adres:</p>

                        <p class="email email-big text-center"><?= $pismo['to_email'] ?></p>

                        <div class="form-group">
                            <label for="senderName">Podaj swoje imię i nazwisko bądź nazwę
                                instytucji:</label>
                            <input name="name" class="form-control" type="text" id="senderName"
                                   value="" required="required"/>
                        </div>

                        <div class="form-group">
                            <label for="senderEmail">Podaj swój adres e-mail:</label>
                            <input name="email" class="form-control" type="email"
                                   id="senderEmail" required="required"/>
                        </div>

                        <div class="additional-desc">
                            <p>W polu <b>CC</b> wiadomości zostanie podany Twój
                                adres e-mail - otrzymasz więc kopię wysłanego
                                pisma.
                            </p>

                            <p>W polu <b>Reply-to</b> wiadomości również
                                zostanie podany Twój adres email, aby adresat
                                przesłał odpowiedź bezpośrednio na Twój adres.
                            </p>
                        </div>

                    <? } ?>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">Anuluj
                    </button>
                                        
                    <button name="send" value="Wyślij" type="submit" class="btn btn-primary btn-icon auto-width"><i class="icon glyphicon glyphicon glyphicon-send"></i>Wyślij pismo</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<div class="lettersSend">
	<div class="row margin-top-20">
        <div class="col-md-12">
	        
	        <p class="text-center">
                <button data-action="send" class="btn btn-primary btn-icon auto-width"><i class="icon glyphicon glyphicon glyphicon-send"></i>Wyślij pismo...</button>
            </p>
	        
        </div>
	</div>
</div>

<? } ?>

<div class="lettersResponses">
    <div class="row margin-top-20">
        <div class="col-md-12">
            
            <ul class="responses">
	            <? if(isset($responses) && is_array($responses) && count($responses)) {  ?>
                    <? foreach($responses as $response) { ?>
                        <li class="response">
                            <h2>
								<?= $response['Response']['title'] ?>
								<span class="date"><?= dataSlownie($response['Response']['date']) ?></span>
							</h2>
                            <div class="content">
								<?= $response['Response']['content'] != '' ? htmlspecialchars($response['Response']['content']) : 'Brak treści' ?>
							</div>
							<? if(count($response['files'])) { ?>
								<div class="files">
									<? foreach($response['files'] as $file) { ?>
										<div class="file">
											<a target="_blank" href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>/attachment/<?= $file['ResponseFile']['id'] ?>"><span class="glyphicon glyphicon-download-alt"></span>
												<?= $file['ResponseFile']['src_filename'] != '' ? $file['ResponseFile']['src_filename'] : 'Brak nazwy' ?>
											</a>
										</div>
									<? } ?>
								</div>
							<? } ?>
                        </li>
                    <? } ?>
	            <? } ?>
            </ul>
            
            <? if( $pismo['sent'] ) {?>
            <p class="buttons text-center">
                <button
					data-action="add_response"
					data-letter-alphaid="<?= $pismo['alphaid'] ?>"
					data-letter-slug="<?= $pismo['slug'] ?>"
					class="btn btn-success btn-icon auto-width">
					<i class="icon glyphicon glyphicon-plus-sign"></i>Dodaj odpowiedź na pismo
				</button>
            </p>
            <? } ?>
            
        </div>
    </div>
</div>

<?= $this->element('Start.pageEnd'); ?>
