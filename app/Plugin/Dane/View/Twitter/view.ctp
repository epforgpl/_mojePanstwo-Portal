<?
$this->Combinator->add_libs('css', $this->Less->css('view-twitter', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>

<div class="row">
	<div class="col-sm-9">

<?
echo $this->Dataobject->render($object, 'default', array(
	'page' => true,
));
?>

	</div>
</div>

<?
echo $this->Element('dataobject/pageEnd');
	