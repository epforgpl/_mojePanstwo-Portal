<?php $this->Combinator->add_libs('css', $this->Less->css('view-crawlerpages', array('plugin' => 'Dane'))) ?>
<?php echo $this->Element('dataobject/pageBegin'); ?>

    <div class="object text-center">
        <iframe src="<?= $object->getData('url') ?>" frameborder="0">
            <p>Your browser does not support iframes.</p>
        </iframe>
    </div>

<?php echo $this->Element('dataobject/pageEnd'); ?>