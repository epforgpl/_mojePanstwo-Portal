<? $this->Combinator->add_libs('js', 'Bdl.bdlapp'); ?>

<?= $this->Element('dataobject/pageBegin'); ?>

<? if ($object->getData('opis')) { ?>
    <div class="opis">
        <?= $object->getData('opis') ?>
    </div>
<? } ?>

<?= $this->Element('bdl_select', array('expand_dimension' => $expand_dimension, 'dims' => $dims)); ?>

<?= $this->Element('Bdl.leftsideaccordion', array('tree' => $tree)); ?>

<?= $this->Element('Bdl.item'); ?>

<?= $this->Element('dataobject/pageEnd'); ?>