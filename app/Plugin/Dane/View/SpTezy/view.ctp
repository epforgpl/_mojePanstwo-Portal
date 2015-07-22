<?php $this->Combinator->add_libs('css', $this->Less->css('view-sptezy', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="object">
        <div class="document col-md-10 col-md-offset-1">
            <p>
                <?php echo $object->getData('teza'); ?>
            </p>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>