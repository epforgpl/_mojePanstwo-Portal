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

$this->Combinator->add_libs('js', 'Start.letters-responses-editor.js');

?>
<?php $this->Combinator->add_libs('js', 'Start.pismo.js') ?>
<?php // $this->Combinator->add_libs('js', 'Start.letters-social-share.js') ?>

<?php echo $this->Html->script('/Start/js/zeroclipboard', array('block' => 'scriptBlock')); ?>

<? $href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>

<?= $this->element('Start.pageBegin'); ?>

<header class="collection-header">

	<ul class="breadcrumb">
	  <li><a href="/moje-pisma">Moje Pisma</a></li>
	  <li><a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">Pismo</a></li>
	  <li class="active">Anonimizacja</li>
	</ul>

	<div class="overflow-auto">

		<div class="content pull-left">
			<i class="object-icon icon-applications-pisma"></i>
			<div class="object-icon-side">
                <h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
					<? if($pismo['is_owner']) { ?>
						<input data-url="/start/letters/setDocumentName/<?= $pismo['alphaid'] ?>" class="form-control h1-editable" type="text" name="nazwa" value="<?= $pismo['nazwa'] ?>"/>
					<? } else { ?>
						<?= $pismo['nazwa'] ?>
					<? } ?>
				</h1>
			</div>
		</div>


		

	</div>
</header>

<?

	$share_url = 'https://mojepanstwo.pl/dane/pisma/' . $pismo['numeric_id'];
	if( $pismo['object_id'] ) {

        $share_url = 'https://mojepanstwo.pl/dane/' . $pismo['page_dataset'] . '/' . $pismo['page_object_id'] . ',' . $pismo['page_slug'] . '/pisma/' . $pismo['numeric_id'];

    }
?>

<div class="alert alert-info margin-top-15">
	<h4>Anonimizacja</h4>
	<p>Zaznacz fragmenty pisma, których nie chcesz ujawnić publicznie. Gdy będziesz gotowy, naciśnij przycisk "Opublikuj pismo" na dole ekranu.</p>
</div>

<div class="letter-table">
	<div class="row">
		<div class="col-sm-2">
			<p class="_label">Od:</p>
		</div><div class="col-sm-10">
			<p><?= $pismo['page_name'] ? $pismo['page_name'] : $pismo['from_user_name'] ?></p>
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
	
</div>


<div class="text-center">
	<a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>" class="btn btn-default">Anuluj</a>
    <button type="submit" class="btn btn-primary">Opublikuj pismo</button>
</div>

<?= $this->element('Start.pageEnd'); ?>
