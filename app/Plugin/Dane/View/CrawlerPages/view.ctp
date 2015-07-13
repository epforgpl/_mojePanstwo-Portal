<?php $this->Combinator->add_libs('css', $this->Less->css('view-crawlerpages', array('plugin' => 'Dane'))) ?>
<?php echo $this->Element('dataobject/pageBegin'); ?>

    <div class="object page_image text-center">
        <img src="http://crawler.sds.tiktalik.com/screenshot/<?= $object->getId() ?>.jpg"/>
    </div>

<?php echo $this->Element('dataobject/pageEnd'); ?>