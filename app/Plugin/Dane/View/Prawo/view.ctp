<? echo $this->Element('dataobject/pageBegin'); ?>


    <div class="row">

        <div class="object col-md-12">


            <?= $this->Document->place($object->getData('dokument_id')) ?>
        </div>
    </div>


<?= $this->Element('dataobject/pageEnd'); ?>