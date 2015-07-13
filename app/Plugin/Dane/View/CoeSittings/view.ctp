<?php $this->Combinator->add_libs('css', $this->Less->css('view-coe_sittings', array('plugin' => 'Dane'))) ?>
<?php echo $this->Element('dataobject/pageBegin'); ?>

    <div class="mpanel sitting">
        <?php
        $text = $object->getLayer('text');
        echo $text['html'];
        ?>
    </div>

<?php echo $this->Element('dataobject/pageEnd'); ?>