<?= $this->Element('dataobject/pageBegin'); ?>

<? if ($object->getData('opis')) { ?>
    <div class="opis">
        <?= $object->getData('opis') ?>
    </div>
<? } ?>

<?= $this->Element('bdl_select', array('expand_dimension' => $expand_dimension, 'dims' => $dims)); ?>

<?
$this->Combinator->add_libs('js', 'Bdl.bdlapp');
echo $this->Element('Bdl.leftsideaccordion', array('tree' => $tree));
echo $this->Element('Bdl.item');
?>

<?= $this->Element('dataobject/pageEnd'); ?>