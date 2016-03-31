<?
	$this->Combinator->add_libs('css', $this->Less->css('survey', array('plugin' => 'Admin')));
?>

<? echo $this->Element('headers/main'); ?>

<div id="table">
<?= $survey['culture_surveys']['html']; ?>
</div>

</div>
</div>
</div>