<? echo $this->Element('dataobject/pageBegin'); ?>

    <div class="prawo row">
        <div class="col-md-2 objectSide">

            <? echo $this->Element('Dane.sides/' . $this->request->params['controller'] . '-left'); ?>

        </div>
        <div class="col-md-10 nopadding">
            <div class="object">
                <?= $this->Document->place( $object->getData('dokument_id') ) ?>
            </div>
        </div>

    </div>

<?= $this->Element('dataobject/pageEnd'); ?>