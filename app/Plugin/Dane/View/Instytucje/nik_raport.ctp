<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $raport,
));

?>
    <div class="row">

        <div class="col-lg-10">

	        <?= $this->Document->place($raport->getData('dokument_id')) ?>

        </div>
    </div>
<?

echo $this->Element('dataobject/pageEnd');