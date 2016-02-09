<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $sprawozdanie,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));
?>

<div class="row">
	<div class="col-sm-9">

        <?= $this->Document->place($sprawozdanie->getData('dokument_id')) ?>

    </div>
</div>

<?
echo $this->Element('dataobject/pageEnd');
