<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letters-moje', array('plugin' => 'Start'))) ?>
<?php // $this->Combinator->add_libs('js', 'Start.letters-my.js') ?>

<?
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">		
		
		<div class="container">

			<div class="header-wrap">
				<h1 class="pull-left smaller">Moje pisma</h1>
				<a
			        href="/moje-pisma/nowe"
			        class="btn-success btn-xs mp-btn-sm btn-icon submit width-auto pull-left">
			        <i aria-hidden="true" class="icon glyphicon glyphicon-plus"></i>
			        Stwórz nowe pismo
			    </a>
			</div>
			
			<? if (!$this->Session->read('Auth.User.id')) { ?>
			    <div class="col-xs-12 nopadding margin-top-15 margin-bottom--20">
			        <div class="alert-identity alert alert-dismissable alert-info" style="margin-right: 30px;">
			            <button type="button" class="close" data-dismiss="alert">×</button>			
			            <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
			                    class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
			                swoim koncie.</p>
			        </div>
			    </div>
			<? } ?>
								
		</div>
		
		
		
		<?= $this->element('Dane.DataBrowser/browser-content', array(
			'displayAggs' => false,
			'app_chapters' => false,
			'forceHideAggs' => true,
			'noResultsPhrase' => 'Nie stworzyłeś jeszcze żadnych pism',
			'paginatorPhrases' => array('pismo', 'pisma', 'pism'),
			'manage' => true,
		)); ?>
		
    </div>
</div>