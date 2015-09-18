<?

echo $this->Element('dataobject/pageBegin');

$params = array();

if(isset($object_editable) && in_array('logo', $object_editable)) {
    $params = array(
        'sideElement' => 'Dane.KrsPodmioty/dodaj_dzialanie'
    );
}
?>

<div class="row">
	<div class="col-sm-10">
		<? echo $this->Element('Dane.DataBrowser/browser', $params); ?>
	</div><div class="col-sm-2">
		<? if( $_canEdit ) {?>
		<a href="<?= $object->getUrl() ?>/dodaj_dzialanie" class="btn btn-primary btn-icon margin-top-15"><i aria-hidden="true" class="icon glyphicon glyphicon-plus"></i>Dodaj działanie</a>
		<? } ?>
	</div>
</div>
<?
echo $this->Element('dataobject/pageEnd');