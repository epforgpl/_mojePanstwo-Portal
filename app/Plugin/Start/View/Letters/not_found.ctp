<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letters-moje', array('plugin' => 'Start'))) ?>

<?
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">		
		<div class="container">

			<div class="row">
				<div class="col-xs-12">
				    <p class="msg-main">
				        To pismo nie istnieje lub nie masz do niego dostępu.
				    </p>
				</div>
			</div>
			
		</div>
    </div>
</div>

<?= $this->element('Start.pageEnd'); ?>
