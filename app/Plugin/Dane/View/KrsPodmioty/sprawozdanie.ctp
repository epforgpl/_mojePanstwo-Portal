<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

$sprawozdanie->setOptions(array(
	'view' => 'from_parent',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $sprawozdanie,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));
?>

<div class="row">
	<div class="col-md-2">
		<div class="dataBrowser">
		<?
			echo $this->Element('Dane.DataBrowser/browser-menu', array(
                'menu' => $_submenu,
                'pills' => isset($pills) ? $pills : null
            ));
        ?>
		</div>
	</div>
	<div class="col-md-10 nocontainer">

		<?= $this->Document->place($sprawozdanie->getData('dokument_id')) ?>

	</div>
</div>


<?
echo $this->Element('dataobject/pageEnd');
